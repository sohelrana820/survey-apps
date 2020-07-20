<?php

namespace App\helpers;

/**
 * Class Utility
 * @package App\helpers
 */
class Utility
{
    /**
     * @return bool
     */
    public static function isAppEngine()
    {
        return (isset($_SERVER['SERVER_SOFTWARE']) &&
            strpos($_SERVER['SERVER_SOFTWARE'], 'Google App Engine') !== false);
    }

    /**
     * @return string
     */
    public static function baseURL()
    {
        $protocol = 'http://';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $protocol  = "https://";
        }
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . $host;
    }

    /**
     * @param $data
     * @return array
     */
    public static function processSurveyInputData($data, $userId, $surveyId)
    {
        $processedData = [];
        foreach ($data as $datum)
        {
            $totalScore = $datum['impact_group_size'] + $datum['occurrence_frequency']
                + $datum['experience_impact'] + $datum['business_impact']
                + $datum['financial_feasibility'] +$datum['technical_feasibility'];
            $averageScoe = $totalScore / 7;
            $datum['total_score'] = $totalScore;
            $datum['average_score'] = number_format($averageScoe, 2);
            $datum['user_id'] = $userId;
            $datum['survey_id'] = $surveyId;
            $datum['created_at'] = date('Y-m-d H:i:s');
            $datum['updated_at'] = date('Y-m-d H:i:s');
            $processedData[] = $datum;
        }

        return $processedData;
    }
}
