<?php

declare(strict_types=1);

namespace Bench;

use PhpBench\Attributes\BeforeMethods;
use PhpBench\Attributes\Iterations;
use PhpBench\Attributes\Revs;
use PhpBench\Attributes\Warmup;

#[Revs(100_000), Warmup(2), Iterations(10)]
#[BeforeMethods('prepare')]
class WriteRawBench extends Bench
{
    public function benchAPCu(): void
    {
        \apcu_store('0', 'ABCDEFGH');
    }

    public function benchShm(): void
    {
        \shm_put_var($this->shm, 0, 'ABCDEFGH');
    }

    public function benchShmop(): void
    {
        \shmop_write($this->shmop, 'ABCDEFGH', 0);
    }

    public function benchSync(): void
    {
        $this->sync->write('ABCDEFGH');
    }

    public function benchFFI(): void
    {
        \FFI::memcpy($this->addr, 'ABCDEFGH', 8);
    }
}
