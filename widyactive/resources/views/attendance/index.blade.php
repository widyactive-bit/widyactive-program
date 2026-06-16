@extends('layouts.app')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">QR Attendance Scanner</h1>
        <p class="text-sm text-slate-400 mt-1">Simulate daily training registration passes and instant camera check-ins</p>
    </div>

    <!-- Scanner Simulator Panels -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Left Panel: Athlete QR Pass Generator -->
        <div class="glass-card p-6 border border-white/5 bg-slate-900/40 relative flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-white mb-2">1. Athlete Pass Generator</h3>
                <p class="text-xs text-slate-400 mb-6">Select an athlete to generate their unique encrypted training check-in QR code pass</p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Select Athlete</label>
                        <select id="athlete-select" onchange="generatePass()"
                                class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-white/10 text-sm text-slate-300 outline-none focus:border-orange-500/50 transition">
                            <option value="">-- Choose Athlete --</option>
                            @foreach($athletes as $athlete)
                                <option value="{{ $athlete->id }}" data-name="{{ $athlete->name }}" data-sport="{{ $athlete->sport }}">
                                    {{ $athlete->name }} ({{ $athlete->sport }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Interactive Generated Pass card -->
            <div class="mt-6 flex-1 flex items-center justify-center py-4">
                <div id="qr-pass-card" class="hidden w-72 rounded-2xl border border-white/10 bg-slate-950 p-5 shadow-2xl relative overflow-hidden text-center transition duration-300 hover:scale-[1.02]">
                    <!-- Accent borders -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500"></div>
                    
                    <span class="text-[8px] uppercase tracking-widest font-black text-orange-500">Widyactive Pass ID</span>
                    <h4 id="pass-name" class="text-lg font-extrabold text-white mt-1">John Doe</h4>
                    <p id="pass-sport" class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">Basketball</p>
                    
                    <!-- SVG QR Code simulation -->
                    <div class="my-6 mx-auto h-36 w-36 bg-white p-2.5 rounded-xl flex items-center justify-center shadow-lg relative">
                        <svg class="w-full h-full text-slate-950" viewBox="0 0 100 100">
                            <!-- Outer blocks -->
                            <rect x="0" y="0" width="20" height="20" fill="currentColor"/>
                            <rect x="2" y="2" width="16" height="16" fill="white"/>
                            <rect x="6" y="6" width="8" height="8" fill="currentColor"/>

                            <rect x="80" y="0" width="20" height="20" fill="currentColor"/>
                            <rect x="82" y="2" width="16" height="16" fill="white"/>
                            <rect x="86" y="6" width="8" height="8" fill="currentColor"/>

                            <rect x="0" y="80" width="20" height="20" fill="currentColor"/>
                            <rect x="2" y="82" width="16" height="16" fill="white"/>
                            <rect x="6" y="86" width="8" height="8" fill="currentColor"/>

                            <!-- Middle matrix -->
                            <rect x="40" y="0" width="8" height="15" fill="currentColor"/>
                            <rect x="25" y="25" width="10" height="10" fill="currentColor"/>
                            <rect x="55" y="30" width="15" height="5" fill="currentColor"/>
                            <rect x="35" y="45" width="20" height="20" fill="currentColor"/>
                            <rect x="10" y="40" width="15" height="15" fill="currentColor"/>
                            <rect x="80" y="40" width="10" height="20" fill="currentColor"/>
                            <rect x="45" y="75" width="25" height="10" fill="currentColor"/>
                            <rect x="80" y="75" width="12" height="12" fill="currentColor"/>
                        </svg>
                        <div class="absolute inset-0 border-2 border-orange-500 rounded-xl animate-pulse pointer-events-none"></div>
                    </div>

                    <div class="text-[9px] text-slate-500">
                        Scan at local training terminals
                    </div>
                </div>
                
                <div id="pass-placeholder" class="text-sm text-slate-500 italic py-16 text-center">
                    Please select an athlete to generate a QR Pass
                </div>
            </div>
        </div>

        <!-- Right Panel: Camera Scanner Simulator -->
        <div class="glass-card p-6 border border-white/5 bg-slate-900/40 relative flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-white mb-2">2. Training Scan Terminal</h3>
                <p class="text-xs text-slate-400 mb-6">Position athlete pass in front of scanner to automatically register daily session records</p>
            </div>

            <!-- Visual Camera Viewport Simulator -->
            <div class="relative w-full h-64 bg-slate-950 rounded-2xl border border-white/10 overflow-hidden flex items-center justify-center">
                <!-- Scanner view glows -->
                <div class="absolute inset-0 bg-radial-gradient from-transparent via-slate-950/80 to-slate-950 pointer-events-none z-10"></div>
                
                <!-- Target corners -->
                <div class="absolute top-8 left-8 w-6 h-6 border-t-2 border-l-2 border-orange-500 pointer-events-none z-20"></div>
                <div class="absolute top-8 right-8 w-6 h-6 border-t-2 border-r-2 border-orange-500 pointer-events-none z-20"></div>
                <div class="absolute bottom-8 left-8 w-6 h-6 border-b-2 border-l-2 border-orange-500 pointer-events-none z-20"></div>
                <div class="absolute bottom-8 right-8 w-6 h-6 border-b-2 border-r-2 border-orange-500 pointer-events-none z-20"></div>

                <!-- Laser scan animation -->
                <div id="laser-line" class="hidden absolute top-0 left-0 right-0 h-0.5 bg-orange-500 shadow-[0_0_10px_#f97316] z-20"></div>

                <!-- Scan feedback -->
                <div id="scanner-view-content" class="text-center p-4 z-20">
                    <svg class="mx-auto h-12 w-12 text-slate-500 animate-pulse mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-4v-4m-2 4h-2m-2-4H4m8-8H4m8-8h8"/>
                    </svg>
                    <span class="block text-xs text-slate-400 uppercase tracking-widest font-bold">Scanning Terminal Active</span>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <select id="scan-status" class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-xs text-slate-300 outline-none focus:border-orange-500/50 transition">
                            <option value="present">Check-in Status: Present</option>
                            <option value="late">Check-in Status: Late</option>
                            <option value="absent">Check-in Status: Absent</option>
                        </select>
                    </div>
                    <div>
                        <button onclick="triggerScan()" id="scan-btn" disabled
                                class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-amber-500 disabled:from-slate-800 disabled:to-slate-800 disabled:text-slate-500 text-slate-950 font-bold text-xs tracking-wider uppercase shadow-lg transition duration-200 cursor-pointer">
                            Trigger Scan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Section: Today's Registered Check-ins -->
    <div class="glass-card border border-white/5 overflow-hidden">
        <div class="px-6 py-4 bg-slate-950/60 border-b border-white/5 flex items-center justify-between">
            <h3 class="text-base font-bold text-white">Daily Training Logs (Today: {{ date('M d, Y', strtotime($today)) }})</h3>
            <span class="text-xs text-slate-400 uppercase tracking-widest font-semibold" id="logs-count">{{ count($todayAttendances) }} Checked In</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/5 text-left text-xs text-slate-300">
                <thead class="bg-slate-950/20 text-slate-400 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Athlete</th>
                        <th class="px-6 py-3">Sport</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Check-in Date</th>
                        <th class="px-6 py-3 text-right">Registered At</th>
                    </tr>
                </thead>
                <tbody id="attendance-table-body" class="divide-y divide-white/5">
                    @forelse($todayAttendances as $att)
                        <tr class="hover:bg-white/[0.01]">
                            <td class="px-6 py-4 font-bold text-white">{{ $att->athlete->name }}</td>
                            <td class="px-6 py-4">{{ $att->athlete->sport }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-2 py-0.5 rounded font-bold uppercase text-[9px] tracking-wider
                                    @if($att->status === 'present')
                                        bg-emerald-950/40 text-emerald-400 border border-emerald-500/20
                                    @elseif($att->status === 'late')
                                        bg-amber-950/40 text-amber-400 border border-amber-500/20
                                    @else
                                        bg-red-950/40 text-red-400 border border-red-500/20
                                    @endif">
                                    {{ $att->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">{{ $att->recorded_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right text-slate-500 font-semibold">{{ $att->updated_at->format('h:i A') }}</td>
                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                                No check-ins recorded for today yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Interactive Simulator JS -->
<script>
    var selectedAthleteId = null;

    function generatePass() {
        var select = document.getElementById('athlete-select');
        var val = select.value;
        
        var passCard = document.getElementById('qr-pass-card');
        var placeholder = document.getElementById('pass-placeholder');
        var scanBtn = document.getElementById('scan-btn');

        if (!val) {
            passCard.classList.add('hidden');
            placeholder.classList.remove('hidden');
            scanBtn.setAttribute('disabled', 'true');
            selectedAthleteId = null;
            return;
        }

        var opt = select.options[select.selectedIndex];
        document.getElementById('pass-name').innerText = opt.getAttribute('data-name');
        document.getElementById('pass-sport').innerText = opt.getAttribute('data-sport');

        passCard.classList.remove('hidden');
        placeholder.classList.add('hidden');
        scanBtn.removeAttribute('disabled');
        selectedAthleteId = val;
    }

    function triggerScan() {
        if (!selectedAthleteId) return;

        var laser = document.getElementById('laser-line');
        var btn = document.getElementById('scan-btn');
        var viewContent = document.getElementById('scanner-view-content');
        var status = document.getElementById('scan-status').value;

        btn.setAttribute('disabled', 'true');
        laser.classList.remove('hidden');
        laser.style.top = '0px';

        // Animate laser line moving down
        var pos = 0;
        var interval = setInterval(function () {
            if (pos >= 256) {
                clearInterval(interval);
                laser.classList.add('hidden');
                completeScan(status);
            } else {
                pos += 8;
                laser.style.top = pos + 'px';
            }
        }, 30);
    }

    function completeScan(status) {
        var select = document.getElementById('athlete-select');
        var opt = select.options[select.selectedIndex];
        var name = opt.getAttribute('data-name');
        var sport = opt.getAttribute('data-sport');

        // Submit via Fetch request
        fetch('{{ route("attendance.checkin") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                athlete_id: selectedAthleteId,
                status: status,
                recorded_date: '{{ $today }}',
                notes: 'QR Pass Terminal Scan'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show green scanning flash
                var flash = document.createElement('div');
                flash.className = 'absolute inset-0 bg-emerald-500/20 z-30 transition pointer-events-none';
                document.getElementById('scan-btn').parentNode.parentNode.parentNode.appendChild(flash);
                setTimeout(() => flash.remove(), 600);

                // Add to table dynamically
                var emptyRow = document.getElementById('empty-row');
                if (emptyRow) emptyRow.remove();

                var body = document.getElementById('attendance-table-body');
                
                // If athlete already exists in list, update or remove existing row
                var rows = body.getElementsByTagName('tr');
                for (var i = 0; i < rows.length; i++) {
                    if (rows[i].cells[0].innerText === name) {
                        rows[i].remove();
                        break;
                    }
                }

                var row = document.createElement('tr');
                row.className = 'hover:bg-white/[0.01] animate-fade-in';
                
                var badgeColor = 'bg-slate-900 text-slate-400 border border-white/5';
                if (status === 'present') badgeColor = 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/20';
                else if (status === 'late') badgeColor = 'bg-amber-950/40 text-amber-400 border border-amber-500/20';
                else if (status === 'absent') badgeColor = 'bg-red-950/40 text-red-400 border border-red-500/20';

                row.innerHTML = `
                    <td class="px-6 py-4 font-bold text-white">${name}</td>
                    <td class="px-6 py-4">${sport}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block px-2 py-0.5 rounded font-bold uppercase text-[9px] tracking-wider ${badgeColor}">
                            ${status}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">{{ date('M d, Y', strtotime($today)) }}</td>
                    <td class="px-6 py-4 text-right text-slate-500 font-semibold">Just Now</td>
                `;
                body.insertBefore(row, body.firstChild);

                // Update counts
                var countLabel = document.getElementById('logs-count');
                var count = body.getElementsByTagName('tr').length;
                countLabel.innerText = count + " Checked In";

                // Re-enable select and generate
                document.getElementById('scan-btn').removeAttribute('disabled');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Check-in failed');
            document.getElementById('scan-btn').removeAttribute('disabled');
        });
    }
</script>
@endsection
