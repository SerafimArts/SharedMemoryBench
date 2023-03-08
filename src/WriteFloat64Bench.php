<?php

declare(strict_types=1);

namespace Bench;

use PhpBench\Attributes\BeforeMethods;
use PhpBench\Attributes\Iterations;
use PhpBench\Attributes\Revs;
use PhpBench\Attributes\Warmup;

#[Revs(100_000), Warmup(2), Iterations(10)]
#[BeforeMethods('prepare')]
class WriteFloat64Bench extends Bench
{
    public function benchAPCu(): void
    {
        \apcu_store('0', 0.42);
    }

    public function benchShm(): void
    {
        \shm_put_var($this->shm, 0, 0.42);
    }

    public function benchShmop(): void
    {
        \shmop_write($this->shmop, \pack('d', 0.42), 0);
    }

    public function benchSync(): void
    {
        $this->sync->write(\pack('d', 0.42));
    }

    public function benchFFI(): void
    {
        \FFI::memcpy($this->addr, \pack('d', 0.42), 8);
    }
}
