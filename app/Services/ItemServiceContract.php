<?php

namespace App\Services;

interface ItemServiceContract
{
    public function baseItemsOptions() : string;

    public function itemTypeOptions(  ) : string;

    public function getAllBaseItems() : array;
}