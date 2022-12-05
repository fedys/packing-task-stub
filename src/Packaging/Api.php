<?php


namespace App\Packaging;



use App\Entity\Packaging;
use GuzzleHttp\ClientInterface;

class Api
{
    private ClientInterface $client;
    private string $username;
    private string $key;

    public function __construct(ClientInterface $client, string $username, string $key)
    {
        $this->client = $client;
        $this->username = $username;
        $this->key = $key;
    }

    /**
     * @param Packaging[] $packages
     */
    public function packShipment(ProductList $productList, array $packages): PackagingBox
    {
//        $data = [
//            'w' => 123,
//            'h' => 654,
//            'd' => 963,
//        ];
//
//        return new PackagingBox($data['w'], $data['h'], $data['d']);

        $response = $this->client->request('POST', '/packer/packIntoMany', ['json' => [
            'username' => $this->username,
            'api_key' => $this->key,
            'items' => $this->createItems($productList),
            'bins' => $this->createBins($packages),
        ]]);

        // todo: validation of response

        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $bins = $data['response']['bins_packed'][0]['bin_data'];

        return new PackagingBox($bins['w'], $bins['h'], $bins['d']);
    }

    private function createItems(ProductList $productList): array
    {
        return array_map(function (Product $product) {
            return [
                'id' => $product->getHash(),
                'h' => $product->getHeight(),
                'w' => $product->getWidth(),
                'd' => $product->getLength(),
                'q' => 1,
            ];
        }, $productList->toArray());
    }

    /**
     * @return Packaging[]
     */
    private function createBins(array $packages): array
    {
        return array_map(function (Packaging $packaging) {
            return [
                'id' => $packaging->getId(),
                'h' => $packaging->getHeight(),
                'w' => $packaging->getWidth(),
                'd' => $packaging->getLength(),
                'max_wg' => $packaging->getMaxWeight(),
            ];
        }, $packages);
    }
}
