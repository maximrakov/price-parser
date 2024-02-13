<?php

namespace App\Parser\Api\Mvideo;

use App\DTO\ProductDTO;
use App\Models\Shop;
use App\Parser\Api\ApiResponseHandler;
use App\Parser\CatalogParser;
use App\Repositories\MvideoRepository;
use App\Services\ProductService;

class MvideoCatalogParser implements CatalogParser
{
    private ApiResponseHandler $apiResponseHandler;
    private $categoryId;
    private $url;
    private $productService;
    private $mvideoRepository;
    private $host = 'https://www.mvideo.ru/';
    private $pricesUrl = 'https://www.mvideo.ru/bff/products/prices';
    private $productDetailsUrl = 'https://www.mvideo.ru/bff/product-details/list';
    private $productListingUrl = 'https://www.mvideo.ru/bff/products/listing';

    private $totalProductAmount;

    public function __construct($url, $categoryId)
    {
        $this->productService = new ProductService();
        $this->apiResponseHandler = new ApiResponseHandler();
        $this->mvideoRepository = new MvideoRepository();
        $this->url = $url;
        $this->categoryId = $categoryId;
        $this->totalProductAmount = $this->getNumberOfProducts();
    }

    public function parse(): void
    {
//        $productIdLists = $this->getIdLists(); // получаем список списков с айдишниками, потому что апи позовляет в запросе отсылать только ограниченное количество айди
        $offset = 0;
        $limit = 24;
        while ($offset <= $this->totalProductAmount) {
            $productIdList = $this->getIdLists($offset, $limit);
            $productsInfo = $this->getInfo($productIdList); // получаем название картинку ссылку на товары
            $prices = $this->getPrices($productIdList); // получаем цену товаров
            $shopId = Shop::where('name', 'mvideo')->value('id');
            foreach ($productsInfo as $id => $info) {
                $shop = Shop::where('name', 'mvideo')->first();
                $this->productService->save(new ProductDTO($info['link'], $info['name'], $prices[$id], $info['image'], 'api', $shopId));
            }
            $offset += $limit;
        }
    }

    public function getIdLists($offset = 0, $limit = 24): array
    {
        $productIds = $this->mvideoRepository->getResponse('get', $this->getUrlForIdRetrieving($offset, $limit), $this->url); // получаем порцию айдишников из каталога с помощью апи
        return $this->apiResponseHandler->handle($productIds, 'body.products');
    }

    public function getNumberOfProducts()
    {
        $numberOfProducts = $this->mvideoRepository->getResponse('get', $this->getUrlForIdRetrieving(0, 24), $this->url); // получаем количество товаров в каталоге
        return $this->apiResponseHandler->handle($numberOfProducts, 'body.total');
    }

    public function getPrices($idList): array
    {
        $pricesData = $this->mvideoRepository->getResponse('get', $this->getPricesUrl($idList), $this->url); // получаем апи респонс с ценами на товар
        $prices = [];
        foreach ($this->apiResponseHandler->handle($pricesData, 'body.materialPrices') as $product) {
            $prices[$product->price->productId] = $product->price->salePrice; // вытаскиваем цены из апи респонса
        }
        return $prices;
    }

    private function getInfo($idList): array
    {
        $productsInfoData = $this->mvideoRepository->getResponse('post', $this->productDetailsUrl, $this->url, $this->getPostDataForProductInfoRetrieving($idList)); // получаем апи респонс с информацией о товарах список айди которых мы передали
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
        return $this->pricesUrl . '?productIds=' . implode(',', $idList) . '&addBonusRubles=true&isPromoApplied=true';
    }

    private function getUrlForIdRetrieving($offset, $limit) // получаем урл для получения айди товаров из категории
    {
        return "$this->productListingUrl" . "?categoryId={$this->categoryId}&offset=$offset&limit=$limit";
    }

    private function getFullProductLink($product): string // получем полный урл к товару по его имени и айди
    {
        return $this->host . "products/" . $product->nameTranslit . '-' . $product->productId;
    }

    private function getUrlWithHost($url) // добавляем вначало хост, если ссылка относительная
    {
        return str_contains($url, $this->host) ? $url : $this->host . $url;
    }
}
