<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * Unit test untuk helper dateTimeToString() di app/Helpers/custom_helper.php
 * (mengubah 'Y-m-d H:i:s' => 'd-m-Y H:i:s' tanpa menggeser nilai jam).
 *
 * @internal
 */
final class DateTimeToStringTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        helper('custom');
    }

    public function testFormatTanggalBerubahJamTetapSama(): void
    {
        $this->assertSame('29-09-2026 14:30:45', dateTimeToString('2026-09-29 14:30:45'));
    }

    public function testJamMenitDetikTidakBergeser(): void
    {
        $result = dateTimeToString('2026-09-29 23:59:01');

        $this->assertStringContainsString('23:59:01', $result);
        $this->assertSame('29-09-2026 23:59:01', $result);
    }

    public function testPaddingNolUntukHariBulanDanJam(): void
    {
        $this->assertSame('05-01-2026 08:05:03', dateTimeToString('2026-01-05 08:05:03'));
    }

    public function testNilaiKosongMengembalikanStrip(): void
    {
        $this->assertSame('-', dateTimeToString(''));
        $this->assertSame('-', dateTimeToString(null));
    }

    public function testZeroDateMengembalikanStrip(): void
    {
        $this->assertSame('-', dateTimeToString('0000-00-00 00:00:00'));
        $this->assertSame('-', dateTimeToString('0000-00-00'));
    }

    public function testInputBukanTanggalDikembalikanApaAdanya(): void
    {
        $this->assertSame('bukan-tanggal', dateTimeToString('bukan-tanggal'));
    }

    public function testFormatKustomDapatDiatur(): void
    {
        $this->assertSame('29/09/2026 14:30', dateTimeToString('2026-09-29 14:30:45', 'd/m/Y H:i'));
    }

    public function testFallbackFormatTanggalSajaTetapBisaDiformat(): void
    {
        $this->assertSame('29-09-2026 00:00:00', dateTimeToString('2026-09-29'));
    }
}
