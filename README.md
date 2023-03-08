# PHP SHM Drivers Bench

## Installation

- `docker compose build`
- `docker compose run php composer install`
- `docker compose run php composer bench`

## Results

```sh
> phpbench run --report=grouped
PHPBench (1.2.9) running benchmarks...
with configuration file: /home/memory-bench/phpbench.json
with PHP version 8.2.3, xdebug ❌, opcache ✔

\Bench\WriteFloat64Bench
.....
\Bench\WriteInt64Bench
..........
\Bench\WriteRawBench
...............

Subjects: 15, Assertions: 0, Failures: 0, Errors: 0
WriteFloat64Bench-
+------------+--------+-----+-----------+---------+---------+
| subject    | revs   | its | mem_peak  | mode    | rstdev  |
+------------+--------+-----+-----------+---------+---------+
| benchAPCu  | 100000 | 10  | 590.792kb | 0.056μs | ±2.83%  |
| benchShm   | 100000 | 10  | 590.792kb | 0.212μs | ±18.99% |
| benchShmop | 100000 | 10  | 590.792kb | 0.084μs | ±1.11%  |
| benchSync  | 100000 | 10  | 590.792kb | 0.074μs | ±0.96%  |
| benchFFI   | 100000 | 10  | 590.792kb | 0.069μs | ±1.92%  |
+------------+--------+-----+-----------+---------+---------+

WriteInt64Bench-
+------------+--------+-----+-----------+---------+--------+
| subject    | revs   | its | mem_peak  | mode    | rstdev |
+------------+--------+-----+-----------+---------+--------+
| benchAPCu  | 100000 | 10  | 590.784kb | 0.056μs | ±0.75% |
| benchShm   | 100000 | 10  | 590.784kb | 0.093μs | ±1.51% |
| benchShmop | 100000 | 10  | 590.784kb | 0.087μs | ±0.88% |
| benchSync  | 100000 | 10  | 590.784kb | 0.077μs | ±0.67% |
| benchFFI   | 100000 | 10  | 590.784kb | 0.072μs | ±2.16% |
+------------+--------+-----+-----------+---------+--------+

WriteRawBench-
+------------+--------+-----+-----------+---------+--------+
| subject    | revs   | its | mem_peak  | mode    | rstdev |
+------------+--------+-----+-----------+---------+--------+
| benchAPCu  | 100000 | 10  | 590.784kb | 0.057μs | ±1.96% |
| benchShm   | 100000 | 10  | 590.784kb | 0.089μs | ±3.10% |
| benchShmop | 100000 | 10  | 590.784kb | 0.048μs | ±1.79% |
| benchSync  | 100000 | 10  | 590.784kb | 0.040μs | ±0.78% |
| benchFFI   | 100000 | 10  | 590.784kb | 0.030μs | ±2.76% |
+------------+--------+-----+-----------+---------+--------+
```
