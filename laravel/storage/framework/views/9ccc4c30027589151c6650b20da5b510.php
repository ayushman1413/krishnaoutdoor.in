<!-- =========================================================
     KRISHNA OUTDOOR - ENQUIRY POPUP
     ========================================================= -->

<div
    class="enquiry-popup"
    id="enquiryPopup"
    aria-hidden="true"
>

    <!-- Overlay -->
    <div
        class="enquiry-popup-overlay"
        data-enquiry-close
    ></div>

    <!-- Popup Box -->
    <div
        class="enquiry-popup-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="enquiryPopupTitle"
    >

        <!-- Close -->
        <button
            type="button"
            class="enquiry-popup-close"
            id="enquiryPopupClose"
            aria-label="Close enquiry form"
        >
            &times;
        </button>

        <!-- Header -->
        <div class="enquiry-popup-header">

            <span class="enquiry-popup-tag">
                GET IN TOUCH
            </span>

            <h2 id="enquiryPopupTitle">
                Make an Enquiry
            </h2>

            <p>
                Tell us about your advertising requirements and our team will get back to you.
            </p>

        </div>

        <!-- Form -->
        <form
            id="enquiryPopupForm"
            class="enquiry-popup-form"
            method="POST"
           action="<?php echo e(route('handle.popup.enquiry')); ?>"
        >

            <?php echo csrf_field(); ?>

            <!-- Name -->
            <div class="enquiry-field">

                <label for="popup_name">
                    Name <span>*</span>
                </label>

                <input
                    type="text"
                    id="popup_name"
                    name="name"
                    placeholder="Enter your name"
                    autocomplete="name"
                    required
                >

            </div>


            <!-- Company -->
            <div class="enquiry-field">

                <label for="popup_company">
                    Company Name
                </label>

                <input
                    type="text"
                    id="popup_company"
                    name="company_name"
                    placeholder="Enter company name"
                    autocomplete="organization"
                >

            </div>


            <!-- Mobile -->
            <div class="enquiry-field">

                <label for="popup_mobile">
                    Mobile Number <span>*</span>
                </label>

                <input
                    type="tel"
                    id="popup_mobile"
                    name="mobile"
                    placeholder="Enter 10-digit mobile number"
                    inputmode="numeric"
                    maxlength="10"
                    pattern="[0-9]{10}"
                    autocomplete="tel"
                    required
                >

            </div>


            <!-- Services -->
            <div class="enquiry-field">

                <label for="popup_service">
                    Services <span>*</span>
                </label>

                <select
                    id="popup_service"
                    name="service"
                    required
                >

                    <option value="">
                        Select a service
                    </option>

                    <option value="OOH Media">
                        OOH Media
                    </option>

                    <option value="Transit Media">
                        Transit Media
                    </option>

                    <option value="Digital Media">
                        Digital Media
                    </option>

                    <option value="Hoarding Advertising">
                        Hoarding Advertising
                    </option>

                    <option value="Bus Advertising">
                        Bus Advertising
                    </option>

                    <option value="Mumbai Local Train Advertising">
                        Mumbai Local Train Advertising
                    </option>

                    <option value="Digital Marketing">
                        Digital Marketing
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

            </div>


            <!-- Submit -->
            <button
                type="submit"
                class="enquiry-submit-btn"
            >
                Send Enquiry
                <span>→</span>
            </button>

        </form>

    </div>

</div>


<!-- =========================================================
     ENQUIRY POPUP CSS
     ========================================================= -->

<style>

.enquiry-popup {
    position: fixed;
    inset: 0;
    z-index: 999999;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 12px;

    box-sizing: border-box;
}

.enquiry-popup.is-open {
    display: flex !important;
}


/* Overlay */

.enquiry-popup-overlay {
    position: absolute;
    inset: 0;

    background: rgba(0, 0, 0, 0.72);

    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
}


/* Popup */

.enquiry-popup-box {
    position: relative;
    z-index: 2;

    width: 100%;
    max-width: 390px;

    max-height: calc(100vh - 30px);

    overflow-y: auto;

    box-sizing: border-box;

    padding: 20px 20px 18px;

    background: #ffffff;

    border-radius: 12px;

    box-shadow:
        0 20px 55px rgba(0, 0, 0, 0.35);

    animation: enquiryPopupShow .2s ease-out;
}


/* Animation */

@keyframes enquiryPopupShow {

    from {
        opacity: 0;
        transform: translateY(10px) scale(.97);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}


/* Close Button */

.enquiry-popup-close {

    position: absolute;

    top: 9px;
    right: 9px;

    width: 29px;
    height: 29px;

    padding: 0;

    border: 0 !important;

    border-radius: 50%;

    background: #f2f2f2 !important;

    color: #222 !important;

    font-size: 20px;

    line-height: 29px;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    box-shadow: none !important;

    outline: none !important;

    appearance: none;
    -webkit-appearance: none;
}

.enquiry-popup-close:hover {

    background: #d32634 !important;

    color: #fff !important;

}


/* Header */

.enquiry-popup-header {

    padding-right: 30px;

    margin-bottom: 14px;

}

.enquiry-popup-tag {

    display: block;

    margin-bottom: 4px;

    color: #d32634;

    font-family: 'Aileron', Inter, Arial, sans-serif;

    font-size: 9px;

    line-height: 1;

    font-weight: 800;

    letter-spacing: 1px;

}

.enquiry-popup-header h2 {

    margin: 0 0 5px;

    color: #111;

    font-family: 'Aileron', Inter, Arial, sans-serif;

    font-size: 22px;

    line-height: 1.15;

    font-weight: 800;

}

.enquiry-popup-header p {

    margin: 0;

    color: #666;

    font-family: Inter, Arial, sans-serif;

    font-size: 11px;

    line-height: 1.4;

}


/* Form */

.enquiry-popup-form {

    display: flex;

    flex-direction: column;

    gap: 9px;

}

.enquiry-field {

    display: flex;

    flex-direction: column;

    gap: 4px;

}

.enquiry-field label {

    color: #222;

    font-family: Inter, Arial, sans-serif;

    font-size: 10px;

    line-height: 1.2;

    font-weight: 700;

}

.enquiry-field label span {

    color: #d32634;

}


/* Inputs */

.enquiry-field input,
.enquiry-field select {

    width: 100%;

    height: 37px;

    padding: 0 10px;

    box-sizing: border-box;

    border: 1px solid #d9d9d9 !important;

    border-radius: 6px !important;

    background: #fff !important;

    color: #222 !important;

    font-family: Inter, Arial, sans-serif;

    font-size: 11px;

    outline: none;

    box-shadow: none !important;

    appearance: none;
    -webkit-appearance: none;

}

.enquiry-field input:focus,
.enquiry-field select:focus {

    border-color: #d32634 !important;

    box-shadow: 0 0 0 2px rgba(211, 38, 52, .08) !important;

}


/* Submit */

.enquiry-submit-btn {

    width: 100%;

    height: 40px;

    margin-top: 3px;

    padding: 0;

    border: 0 !important;

    border-radius: 6px !important;

    background: #d32634 !important;

    color: #fff !important;

    font-family: Inter, Arial, sans-serif;

    font-size: 11px;

    font-weight: 800;

    cursor: pointer;

    outline: none !important;

    box-shadow: none !important;

    appearance: none;
    -webkit-appearance: none;

    transition: .2s ease;

}

.enquiry-submit-btn span {

    margin-left: 5px;

}

.enquiry-submit-btn:hover {

    background: #b8202c !important;

    color: #fff !important;

    transform: translateY(-1px);

}


/* Stop page scrolling */

body.enquiry-popup-open {

    overflow: hidden !important;

}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 600px) {

    .enquiry-popup {

        padding: 10px;

    }

    .enquiry-popup-box {

        max-width: 340px;

        max-height: calc(100vh - 20px);

        padding: 18px 16px 16px;

        border-radius: 11px;

    }

    .enquiry-popup-header {

        margin-bottom: 12px;

    }

    .enquiry-popup-header h2 {

        font-size: 20px;

    }

    .enquiry-popup-header p {

        font-size: 10px;

        line-height: 1.35;

    }

    .enquiry-popup-form {

        gap: 8px;

    }

    .enquiry-field {

        gap: 3px;

    }

    .enquiry-field label {

        font-size: 10px;

    }

    .enquiry-field input,
    .enquiry-field select {

        height: 35px;

        font-size: 11px;

    }

    .enquiry-submit-btn {

        height: 38px;

        font-size: 11px;

    }

}


/* Very small phones */

@media (max-width: 380px) {

    .enquiry-popup-box {

        max-width: 320px;

        padding: 16px 14px 14px;

    }

    .enquiry-popup-header h2 {

        font-size: 19px;

    }

}

</style>


<!-- =========================================================
     ENQUIRY POPUP JAVASCRIPT
     ========================================================= -->

<script>

(function () {

    function initEnquiryPopup() {

        const popup = document.getElementById('enquiryPopup');

        if (!popup) {
            return;
        }

        const closeButton =
            document.getElementById('enquiryPopupClose');

        const triggers =
            document.querySelectorAll('.enquiry-popup-trigger');

        const closeElements =
            popup.querySelectorAll('[data-enquiry-close]');


        /* Open */

        function openPopup(event) {

            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            popup.classList.add('is-open');

            popup.setAttribute('aria-hidden', 'false');

            document.body.classList.add('enquiry-popup-open');

        }


        /* Close */

        function closePopup(event) {

            if (event) {
                event.preventDefault();
            }

            popup.classList.remove('is-open');

            popup.setAttribute('aria-hidden', 'true');

            document.body.classList.remove('enquiry-popup-open');

        }


        /* Trigger buttons */

        triggers.forEach(function (trigger) {

            trigger.addEventListener(
                'click',
                openPopup
            );

        });


        /* Close button */

        if (closeButton) {

            closeButton.addEventListener(
                'click',
                closePopup
            );

        }


        /* Overlay */

        closeElements.forEach(function (element) {

            element.addEventListener(
                'click',
                closePopup
            );

        });


        /* ESC */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape' &&
                    popup.classList.contains('is-open')
                ) {

                    closePopup();

                }

            }
        );


        /* Mobile number - only digits */

        const mobile =
            document.getElementById('popup_mobile');

        if (mobile) {

            mobile.addEventListener(
                'input',
                function () {

                    this.value =
                        this.value
                            .replace(/\D/g, '')
                            .slice(0, 10);

                }
            );

        }

    }


    /* DOM ready */

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initEnquiryPopup
        );

    } else {

        initEnquiryPopup();

    }

})();

</script><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/web/common/enquiry-popup.blade.php ENDPATH**/ ?>