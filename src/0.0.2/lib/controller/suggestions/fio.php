<?php

namespace Imyie\Dadata\Controller\Suggestions;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\ActionFilter;

use Imyie\Dadata\Request;

class Fio extends Controller
{

    public const URL = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/fio';

    public const COUNT = 5;

    /**
     * @return array
     */
    public function configureActions()
    {
        return [
            'getData' => [
                'prefilters' => [
                    new ActionFilter\Csrf(),
                ],
            ],
        ];
    }

    /**
     * @param string $query
     * @param int $count
     * @return array
     */
    public static function getDataAction(string $query, int $count = 0): array
    {
        $request = new Request(self::URL);

        if (empty($count)) {
            $count = Option::get('imyie', 'fio_count', self::COUNT);
        }

        $request->setData(
            [
                'query' => $query,
                'count' => $count,
            ]
        );

        $request->post();

        $result = $request->getResponseArray();

        return [
            'query' => $query,
            'data' => $result,
        ];
    }

}
