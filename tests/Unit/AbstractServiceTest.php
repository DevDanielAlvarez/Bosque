<?php

use AstroDaniel\Bosque\AbstractService;
use Illuminate\Database\Eloquent\Model;
use Mockery;

beforeEach(function(){
    $this->modelMocked = Mockery::mock(Model::class);
    $this->fakeService = new class ($this->modelMocked) extends AbstractService{};
});

it('can set a record', function(){
    expect($this->fakeService->getRecord())->toBe($this->modelMocked);
});