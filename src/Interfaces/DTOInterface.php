<?php

namespace AstroDaniel\Bosque\Interfaces;

interface DTOInterface {
  public function toArray() : array;
  public function toJson() : string;
}


