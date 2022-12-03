<?php

namespace App\Services;

interface NearService
{
   public function get_nearest($lat, $lon): array;
}
