@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pusat Komunikasi & Inquiry</h1>
        <p class="page-subtitle">Manajemen interaksi strategis dengan calon mitra penghuni secara sistematis</p>
    </div>
    <div class="page-actions" style="display: flex; gap: 12px; align-items: center;">
        <div style="position:relative; min-width: 280px;">
            <input type="text" placeholder="Filter percakapan atau entitas..." style="width:100%; padding: 10px 16px 10px 40px; background: #fff; border: 1.5px solid var(--border); border-radius: 100px; font-size: 13px; font-weight: 500; transition: 0.2s;" onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(var(--primary-rgb), 0.08)';" onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none';">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); width:18px; height:18px; opacity:0.4;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
    </div>
</div>

<div class="card" style="border:none; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
    <div class="card-header" style="background: #fff; border-bottom: 1.5px solid var(--border); padding: 20px 24px;">
        <div class="card-title" style="font-size: 16px; font-weight: 800;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary);"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            Log Interaksi Terkini
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">ENTITAS PENGIRIM</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">OBJEK PROPERTI</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">SUBSTANSI KOMUNIKASI</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">KRONOLOGI</th>
                        <th style="padding: 16px 24px; background: var(--bg); text-align: right; padding-right: 32px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        @php
                            $colors = ['#6366f1', '#ec4899', '#f59e0b', '#10b981', '#3b82f6'];
                            $idx = ord(substr($group->sender->name, 0, 1)) % count($colors);
                            $bgCol = $colors[$idx];
                        @endphp
                        <tr class="inbox-row {{ $group->unread_count > 0 ? 'unread' : '' }}" style="transition: 0.2s; cursor: pointer;" onclick="window.location='{{ route('pemilik-kos.inquiries.show', $group->sample_id) }}'">
                            <td style="padding: 16px 24px;">
                                <div class="user-cell">
                                    <div class="user-av" style="background: {{ $bgCol }}; color: #fff; width: 44px; height: 44px; font-size: 18px; font-family: 'Syne'; font-weight: 800; border-radius: 12px; position:relative; box-shadow: 0 4px 12px {{ $bgCol }}33;">
                                        {{ strtoupper(substr($group->sender->name, 0, 1)) }}
                                        @if($group->unread_count > 0)
                                            <span style="position:absolute; top:-6px; right:-6px; background:var(--danger); color:#fff; font-size:10px; min-width:20px; height:20px; border-radius:10px; display:flex; align-items:center; justify-content:center; border:2px solid #fff; font-weight:800; box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);">{{ $group->unread_count }}</span>
                                        @endif
                                    </div>
                                    <div class="user-info">
                                        <strong style="font-size: 15px; color: var(--text);">{{ $group->sender->name }}</strong>
                                        <span style="font-size: 12px; color: var(--text-muted);">{{ $group->sender->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--primary);"></div>
                                    <span style="font-size: 13px; font-weight: 700; color: var(--text);">{{ $group->listing->name }}</span>
                                </div>
                                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px; padding-left: 16px;">Kategori: {{ $group->listing->category->name ?? '-' }}</div>
                            </td>
                            <td>
                                <div style="max-width: 320px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 13px; line-height: 1.5;">
                                    @if($group->unread_count > 0)
                                        <span style="color: var(--text); font-weight: 700;">{{ $group->last_message }}</span>
                                    @else
                                        <span style="color: var(--text-muted);">{{ $group->last_message }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 12px; font-weight: 600; color: var(--text-muted);">{{ \Carbon\Carbon::parse($group->last_message_at)->diffForHumans() }}</div>
                                <div style="font-size: 10px; opacity: 0.5; margin-top: 2px;">{{ \Carbon\Carbon::parse($group->last_message_at)->format('H:i') }}</div>
                            </td>
                            <td style="text-align: right; padding-right: 32px;">
                                <div class="action-btn-circle" style="width: 40px; height: 40px; border-radius: 50%; border: 1.5px solid var(--border); display: inline-flex; align-items: center; justify-content: center; color: var(--text-muted); transition: 0.2s;">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 100px 24px;">
                                <div style="width: 80px; height: 80px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                                    <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity: 0.2;"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                </div>
                                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); font-family: 'Syne'; margin-bottom: 8px;">Kotak Masuk Steril</h3>
                                <p style="color: var(--text-muted); font-size: 14px; max-width: 300px; margin: 0 auto;">Seluruh korespondensi pasar akan terakumulasi secara sistematis di panel ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .inbox-row:hover {
        background: rgba(var(--primary-rgb), 0.03);
    }
    .inbox-row:hover .action-btn-circle {
        border-color: var(--primary);
        color: var(--primary);
        background: #fff;
        transform: translateX(4px);
    }
    .inbox-row.unread {
        background: rgba(var(--primary-rgb), 0.015);
        border-left: 4px solid var(--primary);
    }
    .inbox-row.unread strong {
        color: var(--primary);
    }
    .table-wrap table tr:last-child td {
        border-bottom: none;
    }
    .table-wrap table td {
        border-bottom: 1px solid var(--border);
    }
</style>
@endsection
