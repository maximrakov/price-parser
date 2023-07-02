<?php

namespace App\Parser\Api;

use App\Models\Product;
use App\Parser\CustomCurl;
use App\Services\ProductService;

class MvideoCatalogParser
{
    private $curl;
    private ApiResponseHandler $apiResponseHandler;
    private $categoryId;
    private $url;
    private $productService;

    public function __construct($categoryId, $url)
    {
        $this->productService = new ProductService();
        $this->url = $url;
        $this->categoryId = $categoryId;
        $this->apiResponseHandler = new ApiResponseHandler();
        $this->curl = new CustomCurl();
        $this->curl->putHeader('referer', $this->url);
        $this->curl->putHeader('content-type', 'application/json');
        $this->curl->putHeader('accept', 'application/json');
        $this->curl->putHeader('user-agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36');
        $this->curl->setCookie('MVID_GUEST_ID=22673072185; MVID_VIEWED_PRODUCTS=; BIGipServeratg-ps-prod_tcp80=2953108490.20480.0000; _ym_d=1688193266; _ym_uid=1688193266568906629; _ga=GA1.3.942807122.1688193266; _gid=GA1.3.821971262.1688193266; _gid=GA1.2.821971262.1688193266; afUserId=1829f55a-40c4-4abc-b02c-875e470e3298-p; sub_id1_c=99333; sub_id2_c=e59cee410359f840c329c1e741b6b6529bfdf36f; partnerSrc=advcake; advcake_click_id=e59cee410359f840c329c1e741b6b6529bfdf36f; advcake_utm_partner=99333; advcake_utm_webmaster=gdeslon; __cpatrack=advcake_cpa; __allsource=advcake; __sourceid=advcake; advcake_track_url=https%3A%2F%2Fwww.mvideo.ru%2F%3Futm_content%3Dgdeslon%26utm_medium%3Dcpa%26utm_source%3Dadvcake%26utm_campaign%3D99333%26advcake_params%3De59cee410359f840c329c1e741b6b6529bfdf36f%26sub_id1%3D99333%26sub_id2%3De59cee410359f840c329c1e741b6b6529bfdf36f; advcake_track_id=1f75dd96-2e2a-aab6-12ff-aa6fd7c54561; advcake_session_id=aad046d9-d78f-7865-87a6-9735a87aca5b; __lhash_=e4b558abc9de43e10d8b7991bf3d2f93; MVID_AB_TOP_SERVICES=1; MVID_ALFA_PODELI_NEW=true; MVID_BLACK_FRIDAY_ENABLED=true; MVID_CASCADE_CMN=1; MVID_CATALOG_STATE=1; MVID_CHECKOUT_STORE_SORTING=true; MVID_CITY_ID=CityCZ_1216; MVID_CREDIT_SERVICES=true; MVID_CRITICAL_GTM_INIT_DELAY=3000; MVID_FILTER_CODES=true; MVID_FILTER_TOOLTIP=1; MVID_FLOCKTORY_ON=true; MVID_GEOLOCATION_NEEDED=true; MVID_GIFT_KIT=true; MVID_GLP_GLC=2; MVID_GTM_ENABLED=011; MVID_INTERVAL_DELIVERY=true; MVID_IS_NEW_BR_WIDGET=true; MVID_KLADR_ID=7400000100000; MVID_LAYOUT_TYPE=1; MVID_LP_SOLD_VARIANTS=3; MVID_MCLICK=true; MVID_MINDBOX_DYNAMICALLY=true; MVID_MINI_PDP=true; MVID_NEW_ACCESSORY=true; MVID_NEW_LK_CHECK_CAPTCHA=true; MVID_NEW_LK_OTP_TIMER=true; MVID_NEW_MBONUS_BLOCK=true; MVID_PROMO_CATALOG_ON=true; MVID_RECOMENDATION=true; MVID_REGION_ID=7; MVID_REGION_SHOP=S916; MVID_SERVICES=111; MVID_SP=true; MVID_TIMEZONE_OFFSET=5; MVID_TYP_CHAT=true; MVID_WEB_SBP=true; SENTRY_ERRORS_RATE=0.1; SENTRY_TRANSACTIONS_RATE=0.5; MVID_ENVCLOUD=prod2; _ym_isad=2; gdeslon.ru.__arc_domain=gdeslon.ru; gdeslon.ru.user_id=dcc744be-b538-4fb4-987f-a30919694b67; flocktory-uuid=cca16a84-085e-4d06-97d2-382faae65d65-9; tmr_lvid=aba3006ab401bb605c947f84d93a7c51; tmr_lvidTS=1688193276179; uxs_uid=594f85f0-17d9-11ee-8eb9-8523e58d3ccf; AF_SYNC=1688193276889; adrdel=1; adrcid=AHjzj_zqeMnP-dbCZ_HGimw; flacktory=no; BIGipServeratg-ps-prod_tcp80_clone=2953108490.20480.0000; bIPs=-1323973254; cookie_ip_add=87.249.199.132; mindboxDeviceUUID=fca20ab5-81a5-4676-8624-b0d688f1f27b; directCrm-session=%7B%22deviceGuid%22%3A%22fca20ab5-81a5-4676-8624-b0d688f1f27b%22%7D; wurfl_device_id=generic_web_browser; JSESSIONID=J8pLkfwBBVTGWb67cb931WSTS2JLvtp0PFRB13LCYFXFLGFgvRqP!-1412334689; MVID_CALC_BONUS_RUBLES_PROFIT=true; NEED_REQUIRE_APPLY_DISCOUNT=true; MVID_CART_MULTI_DELETE=true; MVID_YANDEX_WIDGET=true; PROMOLISTING_WITHOUT_STOCK_AB_TEST=2; MVID_GET_LOCATION_BY_DADATA=DaData; PRESELECT_COURIER_DELIVERY_FOR_KBT=false; HINTS_FIO_COOKIE_NAME=1; searchType2=2; COMPARISON_INDICATOR=false; MVID_NEW_OLD=eyJjYXJ0IjpmYWxzZSwiZmF2b3JpdGUiOnRydWUsImNvbXBhcmlzb24iOnRydWV9; MVID_OLD_NEW=eyJjb21wYXJpc29uIjogdHJ1ZSwgImZhdm9yaXRlIjogdHJ1ZSwgImNhcnQiOiB0cnVlfQ==; MVID_GTM_BROWSER_THEME=1; deviceType=desktop; __SourceTracker=https%3A%2F%2Fcodebeautify.org%2F__referral; admitad_deduplication_cookie=other_referral; SMSError=; authError=; CACHE_INDICATOR=true; _sp_id.d61c=4758da3d-26a9-4503-8c96-9022a705aba7.1688193267.2.1688203431.1688196017.a954d422-c8dc-4111-91da-644ddcee45cf.f107a3d5-f26f-49d5-aaaa-e85e92c3362e.27ca03e6-d4dd-4b7f-8f41-16a46e0b1f26.1688202306273.27; _ga=GA1.2.942807122.1688193266; tmr_detect=0%7C1688203444757; _ga_CFMZTSS5FM=GS1.1.1688211174.3.0.1688211174.0.0.0; _ga_BNX5WPP3YK=GS1.1.1688211174.3.0.1688211174.60.0.0; cfidsgib-w-mvideo=o84LcFBioOVRsXC7zWMKjIaBDHQtHDlGkEu8xXFs7ap4vJDxa/rbQtG6iqQZQfeRbxjXKnn1O5oUqZIUx472UARVxAZaP4n7Xgx9yScUQAWxgTItnbk0EgP/wgGJj7Is6FeNritPcT/WJd1R4Q5oajLy9EXSvUTN2Yw6F0js; gsscgib-w-mvideo=kAWUq7JfWsU8/9YN8AdZ7Y2EAJaRhq1PPG5UK2R5HlRAb2KeVqb85TV+fDMJOBNpHlN7iRA0Nvk+sbljP5X47FxG2ogEsZsZzWiFtcuNFrxohP9GSsbyAt+PmGOtFaV0v9uptQ5xAm+l4Vj+myK7mEklktRu/pJCxy4Hcr6hePBTD61uQ/23tPpOaKNG9hy2Xnr8eJj2qTJG9wKPjF08rBIXZ5MdGHFNgFDG358PZE2weFBpOE0G+FCRSeZPLA==; gsscgib-w-mvideo=kAWUq7JfWsU8/9YN8AdZ7Y2EAJaRhq1PPG5UK2R5HlRAb2KeVqb85TV+fDMJOBNpHlN7iRA0Nvk+sbljP5X47FxG2ogEsZsZzWiFtcuNFrxohP9GSsbyAt+PmGOtFaV0v9uptQ5xAm+l4Vj+myK7mEklktRu/pJCxy4Hcr6hePBTD61uQ/23tPpOaKNG9hy2Xnr8eJj2qTJG9wKPjF08rBIXZ5MdGHFNgFDG358PZE2weFBpOE0G+FCRSeZPLA==; __hash_=c7e3a82c4e21a0472754d5a487686810; fgsscgib-w-mvideo=Ha2J99377a544099f1e70e071bdb6a9bedfdf131; fgsscgib-w-mvideo=Ha2J99377a544099f1e70e071bdb6a9bedfdf131');
        $this->curl->setRequstMethod('GET');
    }

    public function parse()
    {
        $idLists = $this->getIdList();
        foreach ($idLists as $idList) {
            $info = $this->getInfo($idList);
            $prices = $this->getPrices($idList);
            foreach ($info as $id => $data) {
                $this->productService->save($data['link'], $data['name'], $prices[$id], $data['image']);
            }
        }
    }

    public function getIdList()
    {
        $offset = 0;
        $limit = 24;
        $total = $this->getNumberOfProducts();
        $productId = [];
        while ($offset <= $total) {
            sleep(2);
            $url = "https://www.mvideo.ru/bff/products/listing?categoryId={$this->categoryId}&offset=$offset&limit={$limit}";
            $offset += $limit;
            $this->curl->setRequstMethod('GET');
            $this->curl->putHeader('content-type', null);
            $apiResponse = $this->curl->parse($url);
            $productId[] = $this->apiResponseHandler->handle($apiResponse, 'body.products');
        }
        return $productId;
    }

    public function getNumberOfProducts()
    {
        $this->curl->setRequstMethod('GET');
        $this->curl->putHeader('content-type', null);
        $apiResponse = $this->curl->parse("https://www.mvideo.ru/bff/products/listing?categoryId={$this->categoryId}&offset=0&limit=24");
        return $this->apiResponseHandler->handle($apiResponse, 'body.total');
    }

    public function getPrices($idList)
    {
        $this->curl->setRequstMethod('GET');
        $url = $this->getPricesUrl($idList);
        $this->curl->putHeader('content-type', null);
        $apiResponse = $this->curl->parse($url);
        $prices = [];
        foreach ($this->apiResponseHandler->handle($apiResponse, 'body.materialPrices') as $product) {
            $prices[$product->price->productId] = $product->price->salePrice;
        }
        return $prices;
    }

    private function getInfo($idList)
    {
        $this->curl->setPostFields($this->getPostFieldsString($idList));
        $this->curl->setRequstMethod('POST');
        $this->curl->putHeader('content-type', 'application/json');
        $products = $this->apiResponseHandler->handle($this->curl->parse('https://www.mvideo.ru/bff/product-details/list'), 'body.products');
        $productsInfo = [];
        foreach ($products as $product) {
            $productsInfo[$product->productId] = ['name' => $product->name, 'image' => 'https://www.mvideo.ru/' . $product->image, 'link' => 'https://www.mvideo.ru/products/' . $product->nameTranslit . '-' . $product->productId];
        }
        return $productsInfo;
    }

    private function getPostFieldsString($idList)
    {
        $idListString = '[';
        foreach ($idList as $id) {
            $idListString .= "\"$id\",";
        }
        $idListString = substr($idListString, 0, -1);
        $idListString .= "]";
        $postFields = "{\"productIds\":{$idListString},\"mediaTypes\":[\"images\"],\"category\":true,\"status\":true,\"brand\":true,\"propertyTypes\":[\"KEY\"],\"propertiesConfig\":{\"propertiesPortionSize\":5},\"multioffer\":false}";
        return $postFields;
    }

    private function getPricesUrl($idList)
    {
        $url = 'https://www.mvideo.ru/bff/products/prices?productIds=';
        foreach ($idList as $id) {
            $url .= $id . '%2C';
        }
        $url = substr($url, 0, -3);
        $url .= '&addBonusRubles=true&isPromoApplied=true';
        return $url;
    }
}
