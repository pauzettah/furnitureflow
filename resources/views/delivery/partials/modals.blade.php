{{-- ORDER DETAILS MODAL --}}
<div id="modal-details" class="hidden fixed inset-0 z-50 modal-backdrop bg-navy/60">
    <div class="absolute inset-x-0 bottom-0 modal-panel bg-white rounded-t-3xl max-h-[85vh] overflow-y-auto">
        <div class="sticky top-0 bg-white px-5 pt-4 pb-3 border-b border-slate-100 flex items-center justify-between z-10">
            <h2 class="font-bold text-navy text-lg">Delivery Details</h2>
            <button onclick="closeModal('modal-details')" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4 text-slate-600"></i>
            </button>
        </div>
        <div class="px-5 py-5 space-y-5" id="details-body"></div>
    </div>
</div>

{{-- MARK DELIVERED MODAL --}}
<div id="modal-deliver" class="hidden fixed inset-0 z-50 modal-backdrop bg-navy/60">
    <div class="absolute inset-x-0 bottom-0 modal-panel bg-white rounded-t-3xl">
        <div class="px-5 pt-4 pb-3 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-bold text-navy text-lg">Confirm Delivery</h2>
            <button onclick="closeModal('modal-deliver')" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4 text-slate-600"></i>
            </button>
        </div>
        <div class="px-5 py-5 space-y-5">
            <div class="bg-slate-50 rounded-xl p-3">
                <p class="text-xs text-slate-500 mb-1">Delivering to</p>
                <p class="font-bold text-navy" id="deliver-customer"></p>
                <p class="text-sm text-slate-600" id="deliver-address"></p>
            </div>
            <div id="step-otp">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 rounded-full bg-navy text-white text-xs font-bold flex items-center justify-center">1</div>
                    <p class="font-semibold text-navy text-sm">Customer OTP Verification</p>
                </div>
                <p class="text-xs text-slate-500 mb-3">Ask the customer for their delivery OTP and enter it below.</p>
                <input type="text" id="otp-input" maxlength="4" inputmode="numeric" placeholder="_ _ _ _" class="otp-input w-full border-2 border-slate-200 rounded-xl py-4 text-2xl font-bold text-navy focus:outline-none focus:border-emerald transition-colors">
                <p id="otp-error" class="text-xs text-red-500 mt-2 hidden">Incorrect OTP. Please try again.</p>
                <button onclick="verifyOTP()" class="btn-ripple mt-4 w-full bg-navy text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-navy-800 transition">
                    <i data-lucide="shield-check" class="w-4 h-4"></i> Verify OTP
                </button>
            </div>
            <div id="step-photo" class="hidden">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 rounded-full bg-emerald text-white text-xs font-bold flex items-center justify-center">✓</div>
                    <p class="font-semibold text-emerald text-sm">OTP Verified!</p>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 rounded-full bg-navy text-white text-xs font-bold flex items-center justify-center">2</div>
                    <p class="font-semibold text-navy text-sm">Proof of Delivery Photo</p>
                </div>
                <label class="upload-zone rounded-xl p-6 flex flex-col items-center cursor-pointer block" id="upload-zone">
                    <input type="file" accept="image/*" capture="environment" class="hidden" id="photo-input" onchange="previewPhoto(event)">
                    <i data-lucide="camera" class="w-8 h-8 text-slate-400 mb-2"></i>
                    <p class="text-sm font-semibold text-slate-600">Tap to take photo</p>
                </label>
                <div id="photo-preview" class="hidden mt-3">
                    <img id="preview-img" src="" alt="Proof" class="w-full rounded-xl object-cover max-h-48">
                    <button onclick="clearPhoto()" class="mt-2 text-sm text-red-500">Remove</button>
                </div>
                <button onclick="confirmDelivery()" class="btn-ripple mt-4 w-full bg-emerald text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-emerald-dark transition">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> Confirm Delivery
                </button>
            </div>
        </div>
    </div>
</div>

{{-- SOS MODAL --}}
<div id="modal-sos" class="hidden fixed inset-0 z-50 modal-backdrop bg-navy/60">
    <div class="absolute inset-x-0 bottom-0 modal-panel bg-white rounded-t-3xl">
        <div class="px-5 pt-4 pb-3 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-bold text-navy text-lg">Report an Issue</h2>
            <button onclick="closeModal('modal-sos')" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4 text-slate-600"></i>
            </button>
        </div>
        <div class="px-5 py-5 space-y-3 pb-8">
            @foreach(['Customer not available', 'Wrong address', 'Item damaged', 'Vehicle breakdown', 'Other issue'] as $issue)
            <button onclick="reportIssue('{{ $issue }}')" class="btn-ripple w-full text-left flex items-center gap-3 bg-slate-50 hover:bg-red-50 border border-slate-200 hover:border-red-200 rounded-xl px-4 py-3.5 transition">
                <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 flex-shrink-0"></i>
                <span class="font-medium text-navy text-sm">{{ $issue }}</span>
            </button>
            @endforeach
        </div>
    </div>
</div>

<script>
const deliveries = @json($deliveries ?? []);
let currentDeliveryIndex = null;

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    setTimeout(() => lucide.createIcons(), 50);
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = '';
}

function openDetails(index) {
    const d = deliveries[index];
    const itemsHTML = d.items.map(item => `<li class="flex items-center gap-2 text-sm py-1.5"><span class="w-2 h-2 bg-emerald rounded-full"></span>${item}</li>`).join('');
    document.getElementById('details-body').innerHTML = `
        <div class="space-y-4">
            <div><p class="font-mono text-xs text-slate-400">${d.id}</p><h3 class="font-bold text-navy text-xl">${d.customer}</h3></div>
            <div class="bg-slate-50 rounded-xl p-3"><p class="text-xs text-slate-500">Phone</p><p class="font-semibold">${d.phone}</p><a href="tel:${d.phone.replace(/\s/g,'')}" class="text-emerald text-sm">Call</a></div>
            <div class="bg-slate-50 rounded-xl p-3"><p class="text-xs text-slate-500">Address</p><p class="text-sm">${d.address}</p></div>
            <div><p class="text-xs font-bold mb-2">Items</p><ul class="bg-slate-50 rounded-xl px-4 py-2">${itemsHTML}</ul></div>
            ${d.notes ? `<div class="bg-amber-50 p-3 rounded-xl"><p class="text-sm text-amber-800">${d.notes}</p></div>` : ''}
        </div>
    `;
    openModal('modal-details');
}

function openMarkDelivered(index) {
    currentDeliveryIndex = index;
    const d = deliveries[index];
    document.getElementById('deliver-customer').textContent = d.customer;
    document.getElementById('deliver-address').textContent = d.address;
    document.getElementById('otp-input').value = '';
    document.getElementById('otp-error').classList.add('hidden');
    document.getElementById('step-otp').classList.remove('hidden');
    document.getElementById('step-photo').classList.add('hidden');
    openModal('modal-deliver');
}

function verifyOTP() {
    const d = deliveries[currentDeliveryIndex];
    if (document.getElementById('otp-input').value.trim() === d.otp) {
        document.getElementById('otp-error').classList.add('hidden');
        document.getElementById('step-otp').classList.add('hidden');
        document.getElementById('step-photo').classList.remove('hidden');
        lucide.createIcons();
    } else {
        document.getElementById('otp-error').classList.remove('hidden');
    }
}

function confirmDelivery() {
    showToast('Delivery confirmed!');
    closeModal('modal-deliver');
    location.reload();
}

function openSOS() { openModal('modal-sos'); }
function reportIssue(type) { closeModal('modal-sos'); showToast(`Issue reported: ${type}`); }
function scrollToNext() { const el = document.querySelector('.card-enter:has(.pulse-dot)'); el?.scrollIntoView({ behavior: 'smooth', block: 'center' }); }

function showToast(msg) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-20 left-1/2 -translate-x-1/2 bg-navy text-white px-5 py-3 rounded-2xl shadow-xl z-50 text-sm';
    toast.innerHTML = `<i data-lucide="check-circle" class="w-5 h-5 inline mr-2"></i>${msg}`;
    document.body.appendChild(toast);
    lucide.createIcons();
    setTimeout(() => toast.remove(), 3000);
}
</script>