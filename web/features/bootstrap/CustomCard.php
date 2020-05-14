<?php


use Sebbmyr\Teams\AbstractCard as Card;

/**
 * Simple card for microsoft teams
 */
class CustomCard extends Card
{

    public function getMessage()
    {
        return [
            "@context" => "http://schema.org/extensions",
            "@type" => "MessageCard",
            "themeColor" => !empty($this->data['themeColor']) ? $this->data['themeColor'] : "ff0000",
            "summary" => "Forge Card",
            "title" => $this->data['title'],
            "sections" => [
                [
                    "activityTitle" => "",
                    "activitySubtitle" => "",
                    "activityImage" => "",
                    "facts" => [
                        [
                            "name" => "Feature:",
                            "value" => $this->data['sections']['facts']["feature"]
                        ],
                        [
                            "name" => "Scenario:",
                            "value" => $this->data['sections']['facts']["scenario"]
                        ],
                        [
                            "name" => "Step",
                            "value" => $this->data['sections']['facts']["step"]
                        ]
                    ],
                    "text" => $this->data['sections']['text'],
                    "images" => [
                            [
                                "image" => $this->data['sections']['facts']["image"]
                            ]
                        ]
                ]
            ]
        ];
    }
}