<?php

namespace TFD\WellKnownTrafficAdvice\Tests\Helpers;

use TFD\WellKnownTrafficAdvice\Checks\HighCpuUsageCheck;
use TFD\WellKnownTrafficAdvice\Contracts\LoadAverageServiceInterface;

trait HighCpuUsageCheckTestHelper
{
    protected function createHighCpuUsageCheckMock(
        array $loadAverage = [0.5, 0.3, 0.1],
        int $cpuCores = 4
    ): HighCpuUsageCheck {
        $loadAverageMock = $this->createMock(LoadAverageServiceInterface::class);
        $loadAverageMock->method('getLoadAverage')->willReturn($loadAverage);

        $check = $this->getMockBuilder(HighCpuUsageCheck::class)
            ->setConstructorArgs([$loadAverageMock])
            ->onlyMethods(['getCpuCores'])
            ->getMock();
        $check->method('getCpuCores')->willReturn($cpuCores);

        return $check;
    }

    protected function createLoadAverageServiceMock(array $loadAverage = [0.5, 0.3, 0.1]): LoadAverageServiceInterface
    {
        $mock = $this->createMock(LoadAverageServiceInterface::class);
        $mock->method('getLoadAverage')->willReturn($loadAverage);

        return $mock;
    }
}