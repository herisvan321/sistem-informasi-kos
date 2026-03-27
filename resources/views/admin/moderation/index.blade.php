@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Moderasi Konten</h1>
        <p class="page-subtitle">Tinjau laporan dari pengguna terkait konten tidak pantas</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Review Laporan Pengguna
        </div>
        <form action="{{ route('admin.moderation') }}" method="GET" class="filter-bar">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" class="search-input" placeholder="Cari jenis atau deskripsi..." value="{{ request('search') }}">
            </div>
            <select name="type" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Jenis</option>
                <option value="Spam" {{ request('type') == 'Spam' ? 'selected' : '' }}>Spam</option>
                <option value="Konten Tidak Pantas" {{ request('type') == 'Konten Tidak Pantas' ? 'selected' : '' }}>Konten Tidak Pantas</option>
                <option value="Ulasan Mencurigakan" {{ request('type') == 'Ulasan Mencurigakan' ? 'selected' : '' }}>Ulasan Mencurigakan</option>
            </select>
        </form>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table class="table-hover">
                <thead>
                    <tr>
                        <th>TANGGAL LAPOR</th>
                        <th>KATEGORI</th>
                        <th>PELAPOR</th>
                        <th>KONTEN TERKAIT</th>
                        <th>STATUS ADUAN</th>
                        <th style="text-align:right;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td>
                            <span style="font-size:13px; opacity:0.8;">{{ $report->created_at->format('d/m/Y') }}</span><br>
                            <small style="font-size:10px; opacity:0.5;">{{ $report->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            <span class="badge" style="background:rgba(217,119,6,0.1); color:#D97706; border:1px solid rgba(217,119,6,0.3); font-size:10px;">
                                {{ strtoupper($report->type) }}
                            </span>
                        </td>
                        <td>
                            <div class="user-cell">
                                <div class="user-av" style="width:24px; height:24px; font-size:10px;">
                                    {{ strtoupper(substr($report->reporter->name ?? 'A', 0, 1)) }}
                                </div>
                                <span style="font-size:12px;">{{ $report->reporter->name ?? 'Anonim' }}</span>
                            </div>
                        </td>
                        <td>
                            @if($report->listing)
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="color:var(--text); font-size:13px;">{{ $report->listing->name }}</strong>
                                    <small style="opacity:0.6; font-size:11px;">Listing Kos</small>
                                </div>
                            @else
                                <span class="text-muted" style="font-size:12px; font-style:italic;">Konten terhapus</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $modStatus = [
                                    'Pending' => ['class' => 'amber', 'label' => 'Menunggu'],
                                    'Resolved' => ['class' => 'green', 'label' => 'Selesai'],
                                ];
                                $mst = $modStatus[$report->status] ?? ['class' => 'red', 'label' => $report->status];
                            @endphp
                            <span class="badge badge-{{ $mst['class'] }}">
                                <span class="badge-dot"></span>
                                {{ $mst['label'] }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <button class="act-btn" onclick="initWarnModal('{{ $report->reporter->id ?? '' }}', '{{ addslashes($report->reporter->name ?? 'N/A') }}')" title="Kirim Peringatan">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                </button>
                                @if($report->status == 'Pending')
                                <form action="{{ route('admin.moderation.resolve', $report->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="act-btn success" title="Tandai Selesai">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.moderation.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Hapus konten terlaporkan permanent?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn danger" title="Take down Konten">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 50px; opacity:0.5;">
                            <svg style="width:48px; height:48px; margin-bottom:15px; display:block; margin-left:auto; margin-right:auto;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <p>Tidak ada aduan yang perlu ditinjau saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer" style="padding: 15px 22px;">
        {{ $reports->links() }}
    </div>
</div>

<!-- Modal: Kirim Peringatan -->
<div class="modal-overlay" id="modal-warn" onclick="closeModalOuter(event, 'modal-warn')">
    <div class="modal-box">
        <div class="modal-header">
            <h2 class="modal-title">Kirim Peringatan ke User</h2>
            <button class="modal-close" onclick="closeModal('modal-warn')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="#" method="POST" onsubmit="event.preventDefault(); showToast('success', 'Peringatan telah dikirim!'); closeModal('modal-warn');">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">User (Readonly)</label>
                    <input type="text" id="warn-user-name" class="form-input" readonly>
                    <input type="hidden" id="warn-user-id" name="user_id">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Pelanggaran</label>
                    <select name="violation_type" class="filter-select" style="width: 100%;" required>
                        <option value="Spamming">Spamming</option>
                        <option value="Konten Tidak Pantas">Konten Tidak Pantas</option>
                        <option value="Ulasan Palsu">Ulasan Palsu</option>
                        <option value="Perilaku Buruk">Perilaku Buruk</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pesan Peringatan</label>
                    <textarea name="message" class="form-input" rows="4" placeholder="Tuliskan pesan peringatan di sini..." required></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-warn')">Batal</button>
                <button type="submit" class="btn btn-blue">Kirim Peringatan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function initWarnModal(id, name) {
        document.getElementById('warn-user-id').value = id;
        document.getElementById('warn-user-name').value = name;
        openModal('modal-warn');
    }
</script>
@endsection

