<?php

namespace App\Repositories\Contracts;

interface IPost
{
    public function tagged($slug);
    public function search($search);
}
