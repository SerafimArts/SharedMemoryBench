<?php

declare(strict_types=1);

namespace Bench;

abstract class Bench
{
    private const MEMORY_PERMISSIONS = 0o600;
    private const MEMORY_SIZE = 1024;

    protected \SysvSharedMemory $shm;
    protected \Shmop $shmop;
    protected \SyncSharedMemory $sync;

    private \FFI $ffi;
    protected \FFI\CData|int $addr;

    private function randomId(): int
    {
        $file = \tempnam(\sys_get_temp_dir(), 'shm_');

        return \ftok($file, \chr(\random_int(1, 254)));
    }

    public function prepare(): void
    {
        // Initialize SHM
        $this->shm = \shm_attach($this->randomId(), self::MEMORY_SIZE, self::MEMORY_PERMISSIONS);

        // Initialize Shmop
        $this->shmop = \shmop_open($this->randomId(), 'c', self::MEMORY_PERMISSIONS, self::MEMORY_SIZE);

        // Initialize Sync
        $this->sync = new \SyncSharedMemory('example', self::MEMORY_SIZE);

        // Initialize FFI
        $this->ffi = \FFI::cdef(<<<'ANSI_C'
            typedef struct shmid_ds {
                struct ipc_perm {
                    int key;
                    unsigned int uid;
                    unsigned int gid;
                    unsigned int cuid;
                    unsigned int cgid;
                    unsigned int mode;
                    unsigned short seq;
                } shm_perm;
                int shm_segsz;
                long shm_atime;
                long shm_dtime;
                long shm_ctime;
                int shm_cpid;
                int shm_lpid;
                unsigned short shm_nattch;
                unsigned short shm_unused;
                void *shm_unused2;
                void *shm_unused3;
            } shmid_ds;
            
            int shmget(int key, size_t size, int shmflg);
            void *shmat(int shmid, const void *shmaddr, int shmflg);
            int shmctl(int shmid, int cmd, struct shmid_ds *buf);
        ANSI_C);

        $shm = $this->ffi->new('shmid_ds');
        $id = $this->ffi->shmget($this->randomId(), self::MEMORY_SIZE, 1000);
        $this->ffi->shmctl($id, 2, \FFI::addr($shm));
        $this->addr = $this->ffi->shmat($id, null, 0);
    }
}
