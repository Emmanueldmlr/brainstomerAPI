<?php

namespace App\Data;

class QuestionBank
{
    private function questions(){
        $quizQuestions = [
            [
                "id" => "iq_token",
                "name" => "IQ Token",
                "questions" => [
                    [
                        "id" => 1,
                        "question" => "What feature powers IQ.wiki?",
                        "answer" => "D",
                        "options" => [
                            ["A" => "DeFi and governance token"],
                            ["B" => "Cryptocurrency"],
                            ["C" => "wiki?"],
                            ["D" => "Artificial intelligence"]
                        ]
                    ],
                    [
                        "id" => 2,
                        "question" => "What is the purpose of IQ Token?",
                        "answer" => "D",
                        "options" => [
                            ["A" => "To trade digital assets such as stablecoins and blue chip NFTs"],
                            ["B" => "To be part of IQ.wiki."],
                            ["C" => "To be managed by BrainDAO."],
                            ["D" => "To vote on governance decisions involving both the platform and token itself."]
                        ]
                    ],
                    [
                        "id" => 3,
                        "question" => "When did IQ.wiki become one of the first decentralized applications to integrate artificial intelligence?",
                        "answer" => "C",
                        "options" => [
                            ["A" => "January 2012"],
                            ["B" => "December 2020"],
                            ["C" => "February 2023"],
                            ["D" => "January 2021"]
                        ]
                    ],
                    [
                        "id" => 4,
                        "question" => "What is the BrainDAO team's plan for the AI integration?",
                        "answer" => "A",
                        "options" => [
                            ["A" => "To build a system around training artificial intelligence and incentivize its testing and development."],
                            ["B" => "To summarize large pages like the wiki on the Bored Ape Yacht Club in seconds."],
                            ["C" => "To create a blog post announcing the integration."],
                            ["D" => "To provide rewards in the form of IQ tokens."]
                        ]
                    ],
                    [
                        "id" => 5,
                        "question" => "What will BrainDAO focus on in 2023?",
                        "answer" => "B",
                        "options" => [
                            ["A" => "Rewarding contributions to the IQ.wiki encyclopedia with money"],
                            ["B" => "Integrating AI into the IQ.wiki platform and building a system around training artificial intelligence"],
                            ["C" => "Developing new software for artificial intelligence"],
                            ["D" => "Focusing exclusively on AI integration into other platforms"]
                        ]
                    ],
                    [
                        "id" => 6,
                        "question" => "What backs the value of the IQ token?",
                        "answer" => "D",
                        "options" => [
                            ["A" => "Physical assets"],
                            ["B" => "Bitcoin"],
                            ["C" => "IQ Stakers"],
                            ["D" => "BrainDAO's portfolio of Ethereum, IQ tokens, stablecoins, blue chip NFTs, and other digital assets"]
                        ]
                    ],
                    [
                        "id" => 7,
                        "question" => "In which exchanges is the IQ token listed?",
                        "answer" => "B",
                        "options" => [
                            ["A" => "Coinbase"],
                            ["B" => "Binance, Crypto.com, and Upbit"],
                            ["C" => "KuCoin"],
                            ["D" => "Kraken"]
                        ]
                    ],
                    [
                        "id" => 8,
                        "question" => "What is the first constant product automated market maker with an embedded time-weighted average market maker (TWAMM)?",
                        "answer" => "A",
                        "options" => [
                            ["A" => "Fraxswap"],
                            ["B" => "Bitcoin"],
                            ["C" => "Bitcoin"],
                            ["D" => "Uniswap"]
                        ]
                    ],
                    [
                        "id" => 9,
                        "question" => "What does the HiIQ staking system allow holders to choose?",
                        "answer" => "C",
                        "options" => [
                            ["A" => "When they should stake their IQ tokens"],
                            ["B" => "The amount of IQ token holders receive"],
                            ["C" => "How long they want to lock up their IQ for and the number of IQ tokens they would like to stake"],
                            ["D" => "How many tokens they should lock up"]
                        ]
                    ],
                    [
                        "id" => 10,
                        "question" => "What proposal went up for voting on October 11, 2022?",
                        "answer" => "A",
                        "options" => [
                            ["A" => "IQIP-14: New IQ Tokenomics for the IQ.wiki Platform"],
                            ["B" => "Sushiswap's oSushi Token"],
                            ["C" => "wiki Platform"],
                            ["D" => "Setting up new tokenomics for the IQ token"]
                        ]
                    ]
                ]
            ]
        ];
        return $quizQuestions;
    }

    public function getQuestions($wikiId){
        $questionBanks = $this->questions();
        $questions = null;
        foreach ($questionBanks as $bank){
            if($wikiId==$bank['id']){
                $questions = $bank;
            }
        }
        return $questions;
    }
}
