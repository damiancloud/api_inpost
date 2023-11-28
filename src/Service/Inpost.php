<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Inpost\Items;

class Inpost
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    /**
     * @param  string $resource
     * @param  string $queryParam
     * @param  string $queryValue
     * @return array
     */
    public function getData(string $resource, string $queryParam, string $queryValue): array
    {
        $httpClient = HttpClient::create();
        $url = sprintf('https://api-shipx-pl.easypack24.net/v1/%s?%s=%s', $resource, $queryParam, $queryValue);

        $response = $httpClient->request('GET', $url);

        $jsonContent = $response->getContent();
        $data = json_decode($jsonContent, true);

        $data['query_value'] = $queryValue;

        $recources = $this->serializer->deserialize(json_encode($data), 'App\Entity\Inpost\Resources', 'json');

        $items = [];
        if (isset($data['items'])) {
            $itemsData = $data['items'];
            foreach ($itemsData as &$itemData) {
                $itemData['address'] = json_encode($itemData['address_details'], JSON_UNESCAPED_UNICODE);
            }

            $items = $this->serializer->deserialize(json_encode($itemsData), 'App\Entity\Inpost\Items[]', 'json');
        }

        return [
            'resources' => $recources,
            'items' => $items,
        ];
    }

    /**
     * @param array $inpostData
     * @param array $formData
     * 
     * @return array
     */
    public function findItems(array $inpostData, array $formData): array
    {
        $criteria = [];

        if (isset($formData['street'])) {
            $criteria['street'] = $formData['street'];
        }

        if (isset($formData['city'])) {
            $criteria['city'] = $formData['city'];
        }

        if (isset($formData['postal_code'])) {
            $criteria['postal_code'] = $formData['postal_code'];
        }

        if (empty($criteria)) {
            return [];
        }

        $result = [];

        $items = is_array($inpostData['items'] ?? null) ? $inpostData['items'] : [$inpostData];
        foreach ($items as $item) {
            if ($this->itemMatchesCriteria($item, $criteria)) {
                $result[] = [
                    'name' => $item->getName(),
                    'address' => json_decode($item->getAddress(), true)
                ];
            }
        }

        return $result;
    }

    /**
     * @param Items $item
     * @param array $criteria
     * 
     * @return bool
     */
    private function itemMatchesCriteria(Items $item, array $criteria): bool
    {
        $itemStreet = json_decode($item->getAddress(), true)['street'] ?? null;
        $itemCity = json_decode($item->getAddress(), true)['city'] ?? null;
        $itemPostalCode = json_decode($item->getAddress(), true)['post_code'] ?? null;

        $streetMatches = empty($criteria['street']) || $itemStreet === $criteria['street'];
        $cityMatches = empty($criteria['city']) || $itemCity === $criteria['city'];
        $postalCodeMatches = empty($criteria['postal_code']) || $itemPostalCode === $criteria['postal_code'];

        return $streetMatches && $cityMatches && $postalCodeMatches;
    }
}