{{-- Plan Your Campaign - Lead Capture Popup --}}
<div id="plan-campaign-overlay" class="fixed inset-0 z-[9999] items-center justify-center bg-black bg-opacity-60 p-4" style="display:none;">
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-[480px] max-h-[85vh] sm:max-h-[90vh] overflow-y-auto">

        <button type="button" onclick="closePlanCampaignPopup()" class="absolute top-4 right-4 h-9 w-9 flex items-center justify-center rounded-full hover:bg-gray-100 z-10">
            <i data-feather="x" class="h-5 w-5 stroke-gray-600"></i>
        </button>

        <div class="p-5 sm:p-6 md:p-8 space-y-5 sm:space-y-6">

            <div class="text-center space-y-1.5">
                <h2 class="text-xl sm:text-2xl font-bold text-black">Plan Your Campaign</h2>
                <p class="text-sm font-medium text-web-ascent tracking-wide">Outdoor &bull; Transit &bull; Digital &bull; OTT</p>
            </div>

            <form method="POST" action="{{ route('handle.plan.campaign.enquiry') }}" class="space-y-4">
                @csrf

                <div class="input-group">
                    <label for="plan_campaign_name" class="input-label">Name</label>
                    <input type="text" name="name" id="plan_campaign_name" value="{{ old('name') }}" placeholder="Enter your name" required class="input-box-md">
                    @error('name', 'planCampaign')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="plan_campaign_phone" class="input-label">Mobile Number</label>
                    <div class="flex gap-2">
                        <select name="country_code" id="plan_campaign_country_code" class="input-box-md !w-auto !min-w-[90px] shrink-0">
                            <option value="+91" selected>🇮🇳 +91</option>
                            <option value="+1">🇺🇸 +1</option>
                            <option value="+44">🇬🇧 +44</option>
                            <option value="+971">🇦🇪 +971</option>
                            <option value="+65">🇸🇬 +65</option>
                            <option value="+61">🇦🇺 +61</option>
                            <option value="+49">🇩🇪 +49</option>
                            <option value="+33">🇫🇷 +33</option>
                            <option value="+81">🇯🇵 +81</option>
                            <option value="+86">🇨🇳 +86</option>
                        </select>
                        <input type="text" name="phone" id="plan_campaign_phone"
                            value="{{ old('phone') }}"
                            placeholder="10-digit mobile number"
                            required
                            maxlength="10"
                            minlength="10"
                            pattern="[0-9]{10}"
                            inputmode="numeric"
                            autocomplete="tel"
                            oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)"
                            onkeypress="return (event.charCode>=48&&event.charCode<=57)&&this.value.length<10"
                            class="input-box-md flex-1">
                    </div>
                    @error('phone', 'planCampaign')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="plan_campaign_company" class="input-label">Company Name</label>
                    <input type="text" name="company" id="plan_campaign_company" value="{{ old('company') }}" placeholder="Enter your company name" required class="input-box-md">
                    @error('company', 'planCampaign')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="plan_campaign_requirement" class="input-label">Requirement</label>
                    <select name="requirement" id="plan_campaign_requirement" required class="input-box-md">
                        <option value="">Select your requirement</option>
                        @foreach (\App\Enums\Requirement::cases() as $item)
                            <option value="{{ $item->value }}" @if (old('requirement') == $item->value) selected @endif>{{ $item->label() }}</option>
                        @endforeach
                    </select>
                    @error('requirement', 'planCampaign')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-ascent-md w-full flex items-center justify-center uppercase tracking-wide">GET MY MEDIA PLAN</button>

            </form>

        </div>
    </div>
</div>

<button type="button" onclick="openPlanCampaignPopup()" id="plan-campaign-trigger" class="btn-ascent-sm !py-2.5 !px-5 shadow-xl flex items-center space-x-2 text-xs rounded-full font-semibold" style="position: fixed; z-index: 9998; bottom: 5rem; left: 1rem; transform: none;">
    <i data-feather="send" class="h-3.5 w-3.5 shrink-0"></i>
    <span class="whitespace-nowrap">Plan Your Campaign</span>
</button>

<script>
    // Enforce numeric-only, exactly 10-digit input for the phone field
    document.addEventListener('DOMContentLoaded', function () {
        var phoneInput = document.getElementById('plan_campaign_phone');
        if (!phoneInput) return;

        phoneInput.addEventListener('keydown', function (e) {
            var kc = e.keyCode || e.which;
            var isControlKey = (
                kc === 8   || // Backspace
                kc === 9   || // Tab
                kc === 13  || // Enter
                kc === 27  || // Escape
                kc === 46  || // Delete
                (kc >= 35 && kc <= 40) // Home, End, Arrows
            );
            var isCtrlCmd = e.ctrlKey || e.metaKey; // allow Ctrl+A/C/V/X
            var isDigit   = (kc >= 48 && kc <= 57) ||   // top-row 0-9
                            (kc >= 96 && kc <= 105);    // numpad 0-9
            var hasSelection = this.selectionStart !== this.selectionEnd;

            // Always allow control keys and Ctrl/Cmd combos
            if (isControlKey || isCtrlCmd) return;

            // Block everything that is not a digit
            if (!isDigit) {
                e.preventDefault();
                return;
            }

            // Block digit if already 10 chars and no text is selected
            if (this.value.length >= 10 && !hasSelection) {
                e.preventDefault();
            }
        });

        // Catch paste / autofill — strip non-digits and cap at 10
        phoneInput.addEventListener('input', function () {
            var pos = this.selectionStart;
            var clean = this.value.replace(/\D/g, '').slice(0, 10);
            this.value = clean;
            // restore cursor position if possible
            try { this.setSelectionRange(Math.min(pos, clean.length), Math.min(pos, clean.length)); } catch(e){}
        });
    });

    function openPlanCampaignPopup() {
        document.getElementById('plan-campaign-overlay').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        try { sessionStorage.setItem('plan_campaign_popup_seen', '1'); } catch (e) {}
    }

    function closePlanCampaignPopup() {
        document.getElementById('plan-campaign-overlay').style.display = 'none';
        document.body.style.overflow = '';
    }

    document.getElementById('plan-campaign-overlay').addEventListener('click', function (event) {
        if (event.target === this) {
            closePlanCampaignPopup();
        }
    });

    // Lift the floating trigger above the black footer credit bar only while it would
    // cover it, so "Design & Developed by Tcongs Infotech" stays fully visible.
    var planCampaignTrigger = document.getElementById('plan-campaign-trigger');
    var planCampaignFooterBar = document.querySelector('footer > div.bg-black:last-child');

    function positionPlanCampaignTrigger() {
        if (!planCampaignTrigger || !planCampaignFooterBar) return;
        var barTop = planCampaignFooterBar.getBoundingClientRect().top;
        var needed = window.innerHeight - barTop + 16;
        if (barTop < window.innerHeight && needed > 80) {
            planCampaignTrigger.style.bottom = Math.ceil(needed) + 'px';
        } else {
            planCampaignTrigger.style.bottom = '5rem';
        }
    }

    // On desktop (>=768px) keep button left-docked with more space from edge
    // On mobile keep it left-docked at 1rem so it never clashes with AI widget (bottom-right)
    function positionPlanCampaignTriggerHorizontal() {
        if (!planCampaignTrigger) return;
        if (window.innerWidth >= 768) {
            planCampaignTrigger.style.left = '1.5rem';
            planCampaignTrigger.style.transform = 'none';
        } else {
            planCampaignTrigger.style.left = '1rem';
            planCampaignTrigger.style.transform = 'none';
        }
    }

    planCampaignTrigger.style.transition = 'bottom 0.18s ease-out';
    window.addEventListener('scroll', positionPlanCampaignTrigger, { passive: true });
    window.addEventListener('resize', function () {
        positionPlanCampaignTrigger();
        positionPlanCampaignTriggerHorizontal();
    });
    positionPlanCampaignTrigger();
    positionPlanCampaignTriggerHorizontal();

    @if ($errors->planCampaign->any() ?? false)
        // Re-open the popup automatically if the submission had validation errors
        document.addEventListener('DOMContentLoaded', openPlanCampaignPopup);
    @else
        document.addEventListener('DOMContentLoaded', function () {
            var alreadySeen = false;
            try { alreadySeen = sessionStorage.getItem('plan_campaign_popup_seen') === '1'; } catch (e) {}
            if (!alreadySeen) {
                setTimeout(openPlanCampaignPopup, 8000);
            }
        });
    @endif
</script>
