<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Gedung;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use PHPUnit\Framework\Attributes\Test;
use Carbon\Carbon;

class BookingConflictTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $ruangan;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'mahasiswa']);
        
        $gedung = Gedung::create([
            'nama' => 'Gedung Test',
            'deskripsi' => 'Test building',
            'lokasi' => 'Test location'
        ]);
        
        $this->ruangan = Ruangan::create([
            'gedung_id' => $gedung->id,
            'nama' => 'Ruang Test',
            'kapasitas' => 50,
            'fasilitas' => 'Test facilities'
        ]);
    }

    #[Test]
    public function it_should_detect_exact_time_overlap()
    {
        // Create existing booking
        $existing = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting existing',
            'status' => 'disetujui'
        ]);

        // Try to create conflicting booking with exact same time
        $new = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting new',
            'status' => 'menunggu'
        ]);

        // Test admin approval with conflict detection
        $response = $this->actingAs($this->admin)
            ->patch(route('admin.peminjaman.update', $new), [
                'status' => 'disetujui',
                'catatan_admin' => 'Test approval'
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Gagal menyetujui: Ruangan sudah dipakai di waktu tersebut.');
        
        // Verify booking is still pending
        $this->assertEquals('menunggu', $new->fresh()->status);
    }

    #[Test]
    public function it_should_detect_partial_overlap_start()
    {
        // Existing: 09:00-11:00
        Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting existing',
            'status' => 'disetujui'
        ]);

        // New: 10:00-12:00 (overlaps at the end)
        $new = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '12:00:00',
            'tujuan' => 'Meeting new',
            'status' => 'menunggu'
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.peminjaman.update', $new), [
                'status' => 'disetujui',
                'catatan_admin' => 'Test approval'
            ]);

        $response->assertSessionHas('error');
        $this->assertEquals('menunggu', $new->fresh()->status);
    }

    #[Test]
    public function it_should_detect_partial_overlap_end()
    {
        // Existing: 10:00-12:00
        Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '12:00:00',
            'tujuan' => 'Meeting existing',
            'status' => 'disetujui'
        ]);

        // New: 08:00-11:00 (overlaps at the beginning)
        $new = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting new',
            'status' => 'menunggu'
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.peminjaman.update', $new), [
                'status' => 'disetujui',
                'catatan_admin' => 'Test approval'
            ]);

        $response->assertSessionHas('error');
        $this->assertEquals('menunggu', $new->fresh()->status);
    }

    #[Test]
    public function it_should_detect_complete_overlap()
    {
        // Existing: 09:00-12:00
        Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '12:00:00',
            'tujuan' => 'Meeting existing',
            'status' => 'disetujui'
        ]);

        // New: 10:00-11:00 (completely inside existing)
        $new = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting new',
            'status' => 'menunggu'
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.peminjaman.update', $new), [
                'status' => 'disetujui',
                'catatan_admin' => 'Test approval'
            ]);

        $response->assertSessionHas('error');
        $this->assertEquals('menunggu', $new->fresh()->status);
    }

    #[Test]
    public function it_should_allow_non_overlapping_bookings()
    {
        // Existing: 09:00-11:00
        Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting existing',
            'status' => 'disetujui'
        ]);

        // New: 11:00-13:00 (back-to-back, no overlap)
        $new = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '11:00:00',
            'jam_selesai' => '13:00:00',
            'tujuan' => 'Meeting new',
            'status' => 'menunggu'
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.peminjaman.update', $new), [
                'status' => 'disetujui',
                'catatan_admin' => 'Approved - no conflict'
            ]);

        $response->assertRedirect(route('admin.peminjaman.index'));
        $response->assertSessionHas('success');
        $this->assertEquals('disetujui', $new->fresh()->status);
        $this->assertEquals('Approved - no conflict', $new->fresh()->catatan_admin);
    }

    #[Test]
    public function it_should_ignore_rejected_bookings_in_conflict_check()
    {
        // Existing rejected booking (should be ignored)
        Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting rejected',
            'status' => 'ditolak'
        ]);

        // New booking with same time
        $new = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting new',
            'status' => 'menunggu'
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.peminjaman.update', $new), [
                'status' => 'disetujui',
                'catatan_admin' => 'Should be approved'
            ]);

        $response->assertRedirect(route('admin.peminjaman.index'));
        $response->assertSessionHas('success');
        $this->assertEquals('disetujui', $new->fresh()->status);
    }

    #[Test]
    public function it_should_ignore_different_rooms_in_conflict_check()
    {
        // Create another room
        $otherRuangan = Ruangan::create([
            'gedung_id' => $this->ruangan->gedung_id,
            'nama' => 'Ruang Other',
            'kapasitas' => 30,
            'fasilitas' => 'Other facilities'
        ]);

        // Existing booking in other room
        Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $otherRuangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting in other room',
            'status' => 'disetujui'
        ]);

        // New booking in original room with same time
        $new = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting in original room',
            'status' => 'menunggu'
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.peminjaman.update', $new), [
                'status' => 'disetujui',
                'catatan_admin' => 'Different room, should be allowed'
            ]);

        $response->assertRedirect(route('admin.peminjaman.index'));
        $response->assertSessionHas('success');
        $this->assertEquals('disetujui', $new->fresh()->status);
    }

    #[Test]
    public function it_should_ignore_different_dates_in_conflict_check()
    {
        // Existing booking today
        Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting today',
            'status' => 'disetujui'
        ]);

        // New booking tomorrow with same time
        $new = Peminjaman::create([
            'user_id' => $this->user->id,
            'ruangan_id' => $this->ruangan->id,
            'tanggal' => Carbon::tomorrow()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'tujuan' => 'Meeting tomorrow',
            'status' => 'menunggu'
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.peminjaman.update', $new), [
                'status' => 'disetujui',
                'catatan_admin' => 'Different date, should be allowed'
            ]);

        $response->assertRedirect(route('admin.peminjaman.index'));
        $response->assertSessionHas('success');
        $this->assertEquals('disetujui', $new->fresh()->status);
    }
}