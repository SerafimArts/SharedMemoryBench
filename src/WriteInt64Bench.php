<?php

declare(strict_types=1);

namespace Bench;

use PhpBench\Attributes\BeforeMethods;
use PhpBench\Attributes\Iterations;
use PhpBench\Attributes\Revs;
use PhpBench\Attributes\Warmup;

#[Revs(100_000), Warmup(2), Iterations(10)]
#[BeforeMethods('prepare')]
class WriteInt64Bench extends Bench
{
    public function benchAPCu(): void
    {
        \apcu_store('0', 0xDEAD_BEEF);
    }

    public function benchShm(): void
    {
        \shm_put_var($this->shm, 0, 0xDEAD_BEEF);
    }

    public function benchShmop(): void
    {
        \shmop_write($this->shmop, \pack('q', 0xDEAD_BEEF), 0);
    }

    public function benchSync(): void
    {
        $this->sync->write(\pack('q', 0xDEAD_BEEF));
    }

    public function benchFFI(): void
    {
        \FFI::memcpy($this->addr, \pack('q', 0xDEAD_BEEF), 8);
    }
}
