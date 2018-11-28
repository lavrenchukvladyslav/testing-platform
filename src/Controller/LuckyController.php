<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class LuckyController
{
    public function number()
    {


        return new Response(
            '<h4>hi</h4>'
        );
    }
}