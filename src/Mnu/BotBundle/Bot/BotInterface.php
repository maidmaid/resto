<?php

namespace Mnu\BotBundle\Bot;

interface BotInterface
{
    public function scan();
    public function repair($response);
    public function parseBotRestaurants($html);
}