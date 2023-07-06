<?php

namespace App\Parser\Api;

use App\Parser\CookieService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Http;

class MvideoCatalogParser
{
    private ApiResponseHandler $apiResponseHandler;
    private $categoryId;
    private $url;
    private $productService;
    private $cookieService;
    private $host = 'https://www.mvideo.ru/';
    private $pricesUrl = 'https://www.mvideo.ru/bff/products/prices';
    private $productDetailsUrl = 'https://www.mvideo.ru/bff/product-details/list';
    private $productListingUrl = 'https://www.mvideo.ru/bff/products/listing';

    public function __construct($url, $categoryId)
    {
        $this->cookieService = new CookieService();
        $this->productService = new ProductService();
        $this->apiResponseHandler = new ApiResponseHandler();
        $this->url = $url;
        $this->categoryId = $categoryId;
    }

    public function parse(): void
    {
        $productIdLists = $this->getIdLists(); // получаем список списков с айдишниками, потому что апи позовляет в запросе отсылать только ограниченное количество айди
        foreach ($productIdLists as $productIdList) {
            $productsInfo = $this->getInfo($productIdList); // получаем название картинку ссылку на товары
            $prices = $this->getPrices($productIdList); // получаем цену товаров
            foreach ($productsInfo as $id => $info) {
                $this->productService->save($info['link'], $info['name'], $prices[$id], $info['image']);
            }
        }
    }

    public function getIdLists(): array
    {
        $offset = 0;
        $limit = 24;
        $total = $this->getNumberOfProducts(); // получаем количество товаров в каталоге
        $productId = [];
        while ($offset <= $total) {
            sleep(1);
            $productIds = $this->send('get', $this->getUrlForIdRetrieving($offset, $limit)); // получаем порцию айдишников из каталога с помощью апи
            $productId[] = $this->apiResponseHandler->handle($productIds, 'body.products'); // вытаскиваем айдишники товаров из апи респонса
            $offset += $limit;
        }
        return $productId;
    }

    public function getNumberOfProducts()
    {
        $numberOfProducts = $this->send('get', $this->getUrlForIdRetrieving(0, 24)); // получаем количество товаров в каталоге
        return $this->apiResponseHandler->handle($numberOfProducts, 'body.total');
    }

    public function getPrices($idList): array
    {
        $pricesData = $this->send('get', $this->getPricesUrl($idList)); // получаем апи респонс с ценами на товар
        $prices = [];
        foreach ($this->apiResponseHandler->handle($pricesData, 'body.materialPrices') as $product) {
            $prices[$product->price->productId] = $product->price->salePrice; // вытаскиваем цены из апи респонса
        }
        return $prices;
    }

    private function getInfo($idList): array
    {
        $productsInfoData = $this->send('post', $this->productDetailsUrl, $this->getPostDataForProductInfoRetrieving($idList)); // получаем апи респонс с информацией о товарах список айди которых мы передали
        $products = $this->apiResponseHandler->handle($productsInfoData, 'body.products');
        $productsInfo = [];
        foreach ($products as $product) {
            $productsInfo[$product->productId] = [
                'name' => $product->name,
                'image' => $this->getUrlWithHost($product->image),
                'link' => $this->getFullProductLink($product)
            ];
        }
        return $productsInfo;
    }

    private function getPostDataForProductInfoRetrieving($idList): array //возвращаем тело post запроса для извлечения информации о товарах
    {
        return [
            'productIds' => array_map('strval', $idList),
            'mediaTypes' => [
                'images'
            ],
            'category' => true,
            'status' => true,
            'brand' => true,
            'propertyTypes' => [
                'KEY'
            ],
            'propertiesConfig' => [
                'propertiesPortionSize' => 5
            ],
            'multioffer' => false
        ];
    }

    private function getPricesUrl($idList) // получаем урл с помощью списка айдишников товара, по которому сможем узнать цены этих товаров
    {
        return $this->pricesUrl . '?productIds=' . implode('%2C', $idList) . '&addBonusRubles=true&isPromoApplied=true';
    }

    private function getUrlForIdRetrieving($offset, $limit) // получаем урл для получения айди товаров из категории
    {
        return "$this->productListingUrl" . "?categoryId={$this->categoryId}&offset=$offset&limit=$limit";
    }

    private function getFullProductLink($product): string // получем полный урл к товару по его имени и айди
    {
        return $this->host . "products" . $product->nameTranslit . '-' . $product->productId;
    }

    private function getUrlWithHost($url) // добавляем вначало хост, если ссылка относительная
    {
        return str_contains($url, $this->host) ? $url : $this->host . $url;
    }

    public function send($method, $url, $body = null)
    {
        $headers = ['user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36'];
        $request = Http::withOptions(['cookies' => $this->cookieService->get($this->host)]);
        if ($body) {
            $headers['content-type'] = 'application/json';
            $headers['origin'] = $this->host;
            $headers['referer'] = $this->url;
            return $request
                ->withHeaders($headers)
                ->$method($url, $body)
                ->body();
        }
        return $request
            ->withHeaders($headers)
            ->$method($url)
            ->body();
    }
}
