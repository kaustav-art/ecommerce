<?php
$modal_store_name = html_escape($site_name ?? ($store_settings['site_name'] ?? 'bazaro'));
?>
<style>
    .aq-login-wrapper {
        padding: 40px;
        border-radius: 16px;
        padding-bottom: 35px;
        background: var(--aq-common-white);
        /* box-shadow: 0 30px 70px 0 rgba(1, 15, 28, 0.1); */
    }

    .aq-login-modal-style .modal-content {
        border-radius: 16px;
        border: none;
        padding: 24px 0px;
        position: relative;
        /* box-shadow: 0 25px 60px rgba(0, 0, 0, 0.22); */
        /* background: #ffffff; */
    }

    .aq-login-modal-style .btn-close {
        position: absolute;
        top: 18px;
        right: 18px;
        z-index: 10;
    }

    .aq-login-modal-style .aq-login-title {
        font-size: 26px;
        font-weight: 700;
        color: #010F1C;
        margin-bottom: 6px;
    }

    .aq-login-modal-style .aq-login-top p {
        font-size: 14px;
        color: #55585B;
        margin-bottom: 0;
    }

    .aq-login-modal-style .aq-login-input-box {
        margin-bottom: 18px;
        text-align: left;
    }

    .aq-login-modal-style .aq-form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #010F1C;
        margin-bottom: 6px;
    }

    .aq-login-modal-style .aq-form-label span {
        color: #EF4444;
    }

    .aq-login-modal-style .aq-form-control {
        width: 100%;
        height: 50px;
        border: 1px solid #E0E2E3;
        border-radius: 8px;
        padding: 0 16px;
        font-size: 14px;
        color: #010F1C;
        background: #ffffff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .aq-login-modal-style .aq-form-control:focus {
        border-color: #010F1C;
        outline: none;
        box-shadow: 0 0 0 3px rgba(1, 15, 28, 0.08);
    }

    .aq-login-modal-style .aq-phone-input-group {
        display: flex;
        align-items: stretch;
        width: 100%;
        border: 1px solid #E0E2E3;
        border-radius: 8px;
        background: #ffffff;
        position: relative;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .aq-login-modal-style .aq-phone-input-group:focus-within {
        border-color: #010F1C;
        box-shadow: 0 0 0 3px rgba(1, 15, 28, 0.08);
    }

    /* Custom Country Code Picker */
    .aq-login-modal-style .aq-country-picker {
        position: relative;
        flex-shrink: 0;
    }

    .aq-login-modal-style .aq-country-picker-btn {
        height: 48px;
        background-color: #F8FAFC;
        border: none;
        border-right: 1px solid #E0E2E3;
        border-top-left-radius: 7px;
        border-bottom-left-radius: 7px;
        padding: 0 12px 0 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #010F1C;
        cursor: pointer;
        transition: background-color 0.15s ease, border-color 0.15s ease;
        white-space: nowrap;
        user-select: none;
    }

    .aq-login-modal-style .aq-country-picker-btn:hover {
        background-color: #F1F5F9;
    }

    .aq-login-modal-style .aq-country-picker-btn:focus-visible {
        outline: none;
        background-color: #E2E8F0;
    }

    .aq-login-modal-style .aq-country-flag {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 15px;
        border-radius: 2px;
        overflow: hidden;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.12);
        flex-shrink: 0;
    }

    .aq-login-modal-style .aq-country-flag svg {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .aq-login-modal-style .aq-country-code-val {
        font-size: 14px;
        font-weight: 600;
        color: #010F1C;
        letter-spacing: -0.2px;
    }

    .aq-login-modal-style .aq-country-chevron {
        width: 10px;
        height: 6px;
        color: #64748B;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }

    .aq-login-modal-style .aq-country-picker.is-open .aq-country-chevron {
        transform: rotate(180deg);
    }

    /* Country Dropdown Panel */
    .aq-login-modal-style .aq-country-dropdown-menu {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        z-index: 1065;
        width: 320px;
        max-width: calc(100vw - 64px);
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        box-shadow: 0 12px 30px -4px rgba(1, 15, 28, 0.16), 0 4px 12px -2px rgba(1, 15, 28, 0.08);
        display: none;
        overflow: hidden;
        animation: aqMenuFade 0.18s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .aq-login-modal-style .aq-country-picker.is-open .aq-country-dropdown-menu {
        display: block;
    }

    @keyframes aqMenuFade {
        from {
            opacity: 0;
            transform: translateY(-6px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .aq-login-modal-style .aq-country-search-wrap {
        padding: 10px 12px 8px;
        border-bottom: 1px solid #F1F5F9;
        position: relative;
        background: #FAFAFA;
        border-top-left-radius: 11px;
        border-top-right-radius: 11px;
    }

    .aq-login-modal-style .aq-country-search-wrap .aq-country-search-icon {
        position: absolute;
        left: 24px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 13px;
        pointer-events: none;
    }

    .aq-login-modal-style .aq-country-search-wrap input {
        width: 100%;
        height: 36px;
        padding: 0 12px 0 34px;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        font-size: 13px;
        color: #010F1C;
        background: #ffffff;
        outline: none;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .aq-login-modal-style .aq-country-search-wrap input:focus {
        border-color: #010F1C;
        box-shadow: 0 0 0 2px rgba(1, 15, 28, 0.06);
    }

    .aq-login-modal-style .aq-country-list-scroll {
        max-height: 220px;
        overflow-y: auto;
        padding: 4px 0;
    }

    .aq-login-modal-style .aq-country-list-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .aq-login-modal-style .aq-country-list-scroll::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 3px;
    }

    .aq-login-modal-style .aq-country-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .aq-login-modal-style .aq-country-opt {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 14px;
        cursor: pointer;
        font-size: 13px;
        color: #334155;
        transition: background-color 0.12s ease;
        user-select: none;
    }

    .aq-login-modal-style .aq-country-opt:hover,
    .aq-login-modal-style .aq-country-opt.is-selected {
        background-color: #F1F5F9;
        color: #010F1C;
    }

    .aq-login-modal-style .aq-country-opt-left {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow: hidden;
    }

    .aq-login-modal-style .aq-country-opt-name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 500;
        font-size: 13px;
    }

    .aq-login-modal-style .aq-country-opt-right {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .aq-login-modal-style .aq-country-opt-dial {
        font-weight: 600;
        color: #64748B;
        font-size: 12px;
    }

    .aq-login-modal-style .aq-country-opt.is-selected .aq-country-opt-dial {
        color: #010F1C;
    }

    .aq-login-modal-style .aq-country-opt-check {
        display: none;
        color: #010F1C;
        font-size: 11px;
    }

    .aq-login-modal-style .aq-country-opt.is-selected .aq-country-opt-check {
        display: inline-block;
    }

    .aq-login-modal-style .aq-country-empty {
        padding: 20px 14px;
        text-align: center;
        color: #94A3B8;
        font-size: 13px;
    }

    .aq-login-modal-style .aq-phone-input-group .aq-form-control {
        border: none;
        border-radius: 0 7px 7px 0;
        height: 48px;
        box-shadow: none !important;
        padding: 0 16px;
        flex: 1 1 auto;
        width: 1%;
    }

    .aq-login-modal-style .aq-phone-input-group.email-mode .aq-form-control {
        border-radius: 7px;
    }

    .aq-login-modal-style .aq-login-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        border-radius: 8px;
        background: #010F1C;
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        border: 1px solid #010F1C;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .aq-login-modal-style .aq-login-btn:hover:not(:disabled) {
        background: #1f2937;
        color: #ffffff;
    }

    .aq-login-modal-style .aq-login-btn.btn-transparent {
        background: transparent;
        color: #010F1C;
        border: 1px solid #E0E2E3;
    }

    .aq-login-modal-style .aq-login-btn.btn-transparent:hover {
        background: #F4F5F7;
        border-color: #010F1C;
    }

    .aq-login-modal-style .otp-digit-input {
        width: 46px !important;
        height: 52px !important;
        padding: 0 !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        text-align: center !important;
        border: 1.5px solid #D1D5DB !important;
        border-radius: 8px !important;
        color: #010F1C !important;
        background: #ffffff !important;
    }

    .aq-login-modal-style .otp-digit-input:focus {
        border-color: #010F1C !important;
        box-shadow: 0 0 0 3px rgba(1, 15, 28, 0.1) !important;
        outline: none !important;
    }

    .aq-login-modal-style .aq-login-social {
        gap: 12px;
    }

    .aq-login-modal-style .aq-login-option-item a {
        width: 48px;
        height: 44px;
        border: 1px solid #E0E2E3;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .aq-login-modal-style .aq-login-option-item a:hover {
        border-color: #010F1C;
        background: #F9FAFB;
    }
</style>

<div class="aq-login-modal-style">
    <div class="modal fade" id="exampleModalToggle" role="dialog" aria-labelledby="exampleModalToggle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="aq-login-wrapper">
                    <div class="aq-login-top text-center mb-30" style="margin-bottom: 24px;">
                        <h3 class="aq-login-title" id="login-modal-step-title">Sign in to <?= $modal_store_name; ?>.</h3>
                        <p id="login-modal-step-desc">Enter your Mobile Number or Email to sign in or create an account with OTP.</p>
                    </div>

                    <!-- Alert Box for Error / Success Notifications -->
                    <div id="login-modal-alert" class="alert d-none py-2 px-3 small rounded-3 mb-3"></div>

                    <div class="aq-login-option">
                        <!-- STEP 1: Mobile Number or Email Input -->
                        <div id="login-step-identifier">
                            <form id="otpRequestForm" onsubmit="handleSendOtp(event)">
                                <div class="aq-login-input-wrapper">

                                    <div class="aq-login-input-box">
                                        <label class="aq-form-label" id="login-identifier-label">
                                            Mobile Number <span>*</span>
                                        </label>


                                        <div class="aq-phone-input-group" id="login-identifier-group">
                                            <!-- Modern Country Code Picker -->
                                            <div class="aq-country-picker" id="login-country-picker-wrap">
                                                <button
                                                    type="button"
                                                    class="aq-country-picker-btn"
                                                    id="login-country-btn"
                                                    aria-haspopup="listbox"
                                                    aria-expanded="false"
                                                    aria-label="Select country code"
                                                    title="Select country code">
                                                    <span class="aq-country-flag" id="login-country-flag">
                                                        <svg viewBox="0 0 640 480"><path fill="#f93" d="M0 0h640v160H0z"/><path fill="#fff" d="M0 160h640v160H0z"/><path fill="#128807" d="M0 320h640v160H0z"/><circle cx="320" cy="240" r="56" fill="none" stroke="#008" stroke-width="8"/><circle cx="320" cy="240" r="12" fill="#008"/></svg>
                                                    </span>
                                                    <span class="aq-country-code-val" id="login-country-val">+91</span>
                                                    <svg class="aq-country-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 1L5 5L9 1" stroke="#55585B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </button>

                                                <!-- Synchronized native select for backward compatibility -->
                                                <select
                                                    id="login-country-code"
                                                    class="d-none"
                                                    aria-label="Country code">
                                                    <option value="+91" selected>India (+91)</option>
                                                    <option value="+1">United States (+1)</option>
                                                    <option value="+44">United Kingdom (+44)</option>
                                                    <option value="+1">Canada (+1)</option>
                                                    <option value="+61">Australia (+61)</option>
                                                    <option value="+971">United Arab Emirates (+971)</option>
                                                    <option value="+65">Singapore (+65)</option>
                                                    <option value="+966">Saudi Arabia (+966)</option>
                                                    <option value="+880">Bangladesh (+880)</option>
                                                    <option value="+977">Nepal (+977)</option>
                                                    <option value="+60">Malaysia (+60)</option>
                                                    <option value="+974">Qatar (+974)</option>
                                                    <option value="+965">Kuwait (+965)</option>
                                                    <option value="+968">Oman (+968)</option>
                                                    <option value="+49">Germany (+49)</option>
                                                    <option value="+33">France (+33)</option>
                                                    <option value="+64">New Zealand (+64)</option>
                                                    <option value="+27">South Africa (+27)</option>
                                                </select>

                                                <!-- Dropdown Menu Panel -->
                                                <div class="aq-country-dropdown-menu" id="login-country-menu" role="listbox">
                                                    <div class="aq-country-search-wrap">
                                                        <i class="fa-solid fa-magnifying-glass aq-country-search-icon"></i>
                                                        <input
                                                            type="text"
                                                            id="login-country-search-input"
                                                            placeholder="Search country or code..."
                                                            autocomplete="off"
                                                            aria-label="Search country">
                                                    </div>
                                                    <div class="aq-country-list-scroll">
                                                        <ul class="aq-country-list" id="login-country-list">
                                                            <!-- Rendered via JS -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <input
                                                class="aq-form-control"
                                                type="tel"
                                                id="login-identifier-input"
                                                name="identifier"
                                                placeholder="Enter mobile number"
                                                autocomplete="tel-national"
                                                inputmode="tel"
                                                aria-label="Mobile number"
                                                required>
                                        </div>


                                        <div class="mt-2 d-flex justify-content-end">
                                            <button
                                                type="button"
                                                id="toggle-login-mode-link"
                                                class="btn btn-link p-0 small fw-semibold text-primary text-decoration-underline"
                                                onclick="toggleIdentifierMode()">
                                                Use Email
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="aq-login-suggetions d-sm-flex align-items-center justify-content-between mb-20" style="margin-bottom: 18px;">
                                    <div class="aq-login-remeber d-flex align-items-center gap-2">
                                        <input class="aq-form-checkbox form-check-input" id="remeber" type="checkbox" checked>
                                        <label class="aq-form-checkbox-label small text-muted" for="remeber">Keep me signed in</label>
                                    </div>
                                </div>
                                <div class="aq-login-bottom-wrap mb-30" style="margin-bottom: 22px;">
                                    <button type="submit" id="btn-send-otp" class="aq-login-btn w-100">Continue with OTP</button>
                                </div>
                            </form>

                            <div class="aq-login-mail text-center mb-20" style="margin-bottom: 14px;">
                                <p class="small text-muted mb-0">Or continue with</p>
                            </div>
                            <div class="aq-login-social d-flex flex-wrap align-items-center justify-content-center">
                                <div class="aq-login-option-item">
                                    <a href="javascript:void(0);" onclick="document.getElementById('login-identifier-input').focus();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M19.25 9.83876C19.25 9.04738 19.1845 8.46988 19.0427 7.871H9.82144V11.4429H15.2341C15.125 12.3306 14.5357 13.6674 13.2262 14.5657L13.2078 14.6852L16.1234 16.8987L16.3254 16.9185C18.1805 15.2395 19.25 12.769 19.25 9.83876Z" fill="#4285F4"></path>
                                            <path d="M9.82083 19.25C12.4726 19.25 14.6994 18.3943 16.3254 16.9185L13.2262 14.5657C12.3968 15.1325 11.2831 15.5282 9.82083 15.5282C7.22363 15.5282 5.01929 13.8493 4.23351 11.5285L4.11833 11.5381L1.08667 13.8375L1.04703 13.9455C2.66208 17.0896 5.97954 19.25 9.82083 19.25Z" fill="#34A853"></path>
                                            <path d="M4.23351 11.5285C4.02617 10.9297 3.90675 10.288 3.90675 9.62497C3.90675 8.96188 4.02674 8.32023 4.22317 7.72135L4.21768 7.59381L1.14803 5.25756L1.04759 5.30438C0.381948 6.60912 0 8.07428 0 9.62497C0 11.1757 0.381383 12.6407 1.04703 13.9455L4.23351 11.5285Z" fill="#FBBC05"></path>
                                            <path d="M9.82088 3.72164C11.6651 3.72164 12.9091 4.50233 13.6185 5.15474L16.3903 2.5025C14.688 0.951809 12.4726 0 9.82088 0C5.97957 0 2.66266 2.16024 1.04759 5.30438L4.22317 7.72135C5.01987 5.40066 7.22367 3.72164 9.82088 3.72164Z" fill="#EB4335"></path>
                                        </svg>
                                    </a>
                                </div>
                                <div class="aq-login-option-item">
                                    <a href="javascript:void(0);" onclick="document.getElementById('login-identifier-input').focus();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.4121 17.1597C15.9996 16.2597 16.2186 15.7997 16.6667 14.7897C13.361 13.5298 12.8333 8.79989 16.0991 6.98994C15.1034 5.72997 13.6995 5 12.3753 5C11.4194 5 10.7623 5.25 10.1748 5.48C9.67699 5.66999 9.22894 5.83997 8.67135 5.83997C8.07395 5.83997 7.54623 5.65 6.98865 5.45C6.38129 5.23001 5.74405 5 4.9475 5C3.46394 5 1.88081 5.90998 0.875176 7.46994C-0.53869 9.66988 -0.289768 13.7898 1.99034 17.3097C2.8068 18.5696 3.90205 19.9796 5.32587 19.9996C5.92328 20.0096 6.31159 19.8296 6.73973 19.6396C7.22762 19.4196 7.75532 19.1796 8.68131 19.1796C9.60729 19.1696 10.125 19.4196 10.6129 19.6396C11.0311 19.8296 11.4095 20.0096 11.9969 19.9996C13.4407 19.9796 14.5956 18.4196 15.4121 17.1597Z" fill="#010F1C"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.1721 0C12.3314 1.09997 11.8833 2.18995 11.2959 2.94993C10.6686 3.76991 9.57333 4.40988 8.51791 4.36988C8.32873 3.30991 8.81661 2.21993 9.41402 1.48995C10.0811 0.689972 11.2062 0.0699982 12.1721 0Z" fill="#010F1C"></path>
                                        </svg>
                                    </a>
                                </div>
                                <div class="aq-login-option-item">
                                    <a href="javascript:void(0);" onclick="document.getElementById('login-identifier-input').focus();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M20 10C20 4.5 15.5 0 10 0C4.5 0 0 4.5 0 10C0 15 3.625 19.125 8.375 19.875V12.875H5.875V10H8.375V7.75C8.375 5.25 9.875 3.875 12.125 3.875C13.25 3.875 14.375 4.125 14.375 4.125V6.625H13.125C11.875 6.625 11.5 7.375 11.5 8.125V10H14.25L13.75 12.875H11.375V20C16.375 19.25 20 15 20 10Z" fill="#2151F9"></path>
                                        </svg>
                                    </a>
                                </div>
                                <div class="aq-login-option-item">
                                    <a href="javascript:void(0);" onclick="document.getElementById('login-identifier-input').focus();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.04202 0H0L5.97809 8.15716L0.38242 15H2.96778L7.19998 9.82455L10.958 14.9525H16L9.84822 6.55824L9.85911 6.57272L15.1559 0.0952909H12.5705L8.63704 4.90552L5.04202 0ZM2.78311 1.42858H4.35275L13.2169 13.5238H11.6472L2.78311 1.42858Z" fill="#141414"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2 (When User enters Email first): Enter Mobile Number Form -->
                        <div id="login-step-phone-for-email" class="d-none">
                            <div class="p-2 rounded-3 mb-3 border d-flex align-items-center justify-content-between" style="background:#F9FAFB;">
                                <div class="text-truncate small">
                                    <i class="fa-solid fa-envelope text-dark me-2"></i>
                                    <span class="text-muted">Email: </span>
                                    <strong id="email-preview-label" class="text-dark"></strong>
                                </div>
                                <a href="javascript:void(0);" onclick="backToIdentifierStep()" class="small text-primary text-decoration-underline ms-2 flex-shrink-0">Change</a>
                            </div>

                            <form id="phoneForEmailForm" onsubmit="handlePhoneForEmail(event)">
                                <div class="aq-login-input-wrapper">
                                    <div class="aq-login-input-box">
                                        <label class="aq-form-label">Enter Mobile Number <span>*</span></label>
                                        <input class="aq-form-control" type="tel" id="login-phone-input" placeholder="e.g. 9876543210" required>
                                    </div>
                                </div>
                                <div class="aq-login-bottom-wrap">
                                    <button type="submit" id="btn-phone-for-email" class="aq-login-btn w-100">Continue with OTP</button>
                                </div>
                            </form>
                        </div>

                        <!-- STEP 3: 6-Digit OTP Verification Form -->
                        <div id="login-step-otp" class="d-none">
                            <form id="otpVerifyForm" onsubmit="handleVerifyOtp(event)">
                                <div class="p-3 rounded-3 mb-3 border" style="background:#F9FAFB;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small" style="font-size: 11px;">Verification code sent to</div>
                                            <div class="fw-bold text-dark" id="otp-target-label"></div>
                                            <div id="otp-email-sublabel" class="text-muted small d-none" style="font-size: 11px;"></div>
                                        </div>
                                        <a href="javascript:void(0);" onclick="handleChangeFromOtp()" class="small text-primary text-decoration-underline">Change</a>
                                    </div>
                                    <div id="demo-otp-badge" class="mt-2 py-2 px-3 bg-warning-subtle text-dark border border-warning rounded small d-flex align-items-center justify-content-between" style="font-size: 12px; display: none;">
                                        <span><i class="fa-solid fa-key me-1 text-warning"></i> Demo OTP: <strong id="demo-otp-code"></strong></span>
                                        <button type="button" class="btn btn-sm btn-dark py-0 px-2" style="font-size:11px;" onclick="autoFillStoreOtp()">Auto-Fill</button>
                                    </div>
                                </div>

                                <div class="aq-login-input-box text-center">
                                    <label class="aq-form-label text-center mb-2">Enter 6-Digit OTP Code <span>*</span></label>
                                    <div class="d-flex justify-content-center gap-2 mb-2" id="otp-inputs-container">
                                        <input type="text" maxlength="1" class="otp-digit-input" inputmode="numeric" placeholder="•" required>
                                        <input type="text" maxlength="1" class="otp-digit-input" inputmode="numeric" placeholder="•" required>
                                        <input type="text" maxlength="1" class="otp-digit-input" inputmode="numeric" placeholder="•" required>
                                        <input type="text" maxlength="1" class="otp-digit-input" inputmode="numeric" placeholder="•" required>
                                        <input type="text" maxlength="1" class="otp-digit-input" inputmode="numeric" placeholder="•" required>
                                        <input type="text" maxlength="1" class="otp-digit-input" inputmode="numeric" placeholder="•" required>
                                    </div>
                                </div>

                                <div class="aq-login-bottom-wrap">
                                    <button type="submit" id="btn-verify-otp" class="aq-login-btn w-100">Verify &amp; Continue</button>
                                </div>

                                <div class="text-center mt-3 small">
                                    <span class="text-muted">Didn't receive the code? </span>
                                    <a href="javascript:void(0);" id="btn-resend-otp" onclick="resendOtp()" class="fw-semibold text-dark text-decoration-underline disabled">Resend in <span id="resend-timer-count">30</span>s</a>
                                </div>
                            </form>
                        </div>

                        <!-- STEP 4 (Phone entered first & is new): Ask for Full Name and Email -->
                        <div id="login-step-complete-email-name" class="d-none">
                            <div class="alert alert-success py-2 px-3 small rounded-3 mb-3 d-flex align-items-center">
                                <i class="fa-solid fa-circle-check fs-5 me-2 flex-shrink-0 text-success"></i>
                                <div>
                                    <span class="d-block text-muted" style="font-size: 11px;">Mobile number verified:</span>
                                    <strong id="verified-phone-label-1" class="text-dark"></strong>
                                </div>
                            </div>

                            <form id="completeEmailNameForm" onsubmit="handleCompleteEmailName(event)">
                                <div class="aq-login-input-wrapper">
                                    <div class="aq-login-input-box">
                                        <label class="aq-form-label">Full Name <span>*</span></label>
                                        <input class="aq-form-control" type="text" id="reg-name-1" placeholder="your name" required>
                                    </div>
                                    <div class="aq-login-input-box">
                                        <label class="aq-form-label">Your Email <span>*</span></label>
                                        <input class="aq-form-control" type="email" id="reg-email-1" placeholder="email@address.com" required>
                                    </div>
                                </div>
                                <div class="aq-login-bottom-wrap">
                                    <button type="submit" id="btn-complete-1" class="aq-login-btn w-100">Complete Registration &amp; Login</button>
                                </div>
                            </form>
                        </div>

                        <!-- STEP 5 (Email entered first & Phone is new): Ask for Full Name -->
                        <div id="login-step-complete-name" class="d-none">
                            <div class="p-2 rounded-3 mb-3 border small" style="background:#F9FAFB;">
                                <div class="d-flex align-items-center text-muted mb-1">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i> Email: <strong id="verified-email-label-2" class="text-dark ms-1"></strong>
                                </div>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i> Mobile: <strong id="verified-phone-label-2" class="text-dark ms-1"></strong>
                                </div>
                            </div>

                            <form id="completeNameForm" onsubmit="handleCompleteName(event)">
                                <div class="aq-login-input-wrapper">
                                    <div class="aq-login-input-box">
                                        <label class="aq-form-label">Full Name <span>*</span></label>
                                        <input class="aq-form-control" type="text" id="reg-name-2" placeholder="your name" required>
                                    </div>
                                </div>
                                <div class="aq-login-bottom-wrap">
                                    <button type="submit" id="btn-complete-2" class="aq-login-btn w-100">Complete Registration &amp; Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        window.IS_USER_LOGGED_IN = <?= !empty($is_logged_in) ? 'true' : 'false'; ?>;
        window.REDIRECT_AFTER_LOGIN = window.location.href;
        window.CUSTOM_REDIRECT_ACTIVE = false;
        window.AUTH_FLOW_DATA = {
            flow: 'phone_first',
            email: '',
            phone: '',
            demo_otp: ''
        };
        var resendInterval = null;
        let loginIdentifierMode = 'phone';

        const AQ_COUNTRY_DATA = [
            { code: '+91',  iso: 'in', name: 'India', flag: '<svg viewBox="0 0 640 480"><path fill="#f93" d="M0 0h640v160H0z"/><path fill="#fff" d="M0 160h640v160H0z"/><path fill="#128807" d="M0 320h640v160H0z"/><circle cx="320" cy="240" r="56" fill="none" stroke="#008" stroke-width="8"/><circle cx="320" cy="240" r="12" fill="#008"/></svg>' },
            { code: '+1',   iso: 'us', name: 'United States', flag: '<svg viewBox="0 0 640 480"><path fill="#bd3d44" d="M0 0h640v480H0z"/><path stroke="#fff" stroke-width="37" d="M0 55h640M0 129h640M0 203h640M0 277h640M0 351h640M0 425h640"/><path fill="#192f5d" d="M0 0h260v258H0z"/><circle cx="130" cy="129" r="40" fill="#fff" opacity=".3"/></svg>' },
            { code: '+44',  iso: 'gb', name: 'United Kingdom', flag: '<svg viewBox="0 0 640 480"><path fill="#012169" d="M0 0h640v480H0z"/><path stroke="#fff" stroke-width="60" d="m0 0 640 480m0-480L0 480"/><path stroke="#c8102e" stroke-width="40" d="m0 0 640 480m0-480L0 480"/><path fill="#fff" d="M250 0h140v480H250zM0 170h640v140H0z"/><path fill="#c8102e" d="M275 0h90v480h-90zM0 195h640v90H0z"/></svg>' },
            { code: '+1',   iso: 'ca', name: 'Canada', flag: '<svg viewBox="0 0 640 480"><path fill="#f00" d="M0 0h160v480H0zM480 0h160v480H480z"/><path fill="#fff" d="M160 0h320v480H160z"/><path fill="#f00" d="m320 120 25 50 45-15-20 40 40 20-35 25 15 50-45-25-25 35-25-35-45 25 15-50-35-25 40-20-20-40 45 15z"/></svg>' },
            { code: '+61',  iso: 'au', name: 'Australia', flag: '<svg viewBox="0 0 640 480"><path fill="#00008b" d="M0 0h640v480H0z"/><path fill="#fff" d="M0 0h320v240H0z"/><path fill="#c8102e" d="M130 0h60v240h-60zM0 90h320v60H0z"/><circle cx="480" cy="240" r="20" fill="#fff"/><circle cx="480" cy="120" r="14" fill="#fff"/><circle cx="560" cy="180" r="14" fill="#fff"/><circle cx="400" cy="180" r="14" fill="#fff"/><circle cx="480" cy="360" r="14" fill="#fff"/></svg>' },
            { code: '+971', iso: 'ae', name: 'United Arab Emirates', flag: '<svg viewBox="0 0 640 480"><path fill="#00732f" d="M0 0h640v160H0z"/><path fill="#fff" d="M0 160h640v160H0z"/><path fill="#000" d="M0 320h640v160H0z"/><path fill="#f00" d="M0 0h160v480H0z"/></svg>' },
            { code: '+65',  iso: 'sg', name: 'Singapore', flag: '<svg viewBox="0 0 640 480"><path fill="#ed2939" d="M0 0h640v240H0z"/><path fill="#fff" d="M0 240h640v240H0z"/><circle cx="120" cy="120" r="60" fill="#fff"/><circle cx="140" cy="120" r="50" fill="#ed2939"/></svg>' },
            { code: '+966', iso: 'sa', name: 'Saudi Arabia', flag: '<svg viewBox="0 0 640 480"><path fill="#006c35" d="M0 0h640v480H0z"/><path fill="#fff" d="M160 300h320v20H160zm60-80h200v20H220zm40-40h120v20H260z"/></svg>' },
            { code: '+880', iso: 'bd', name: 'Bangladesh', flag: '<svg viewBox="0 0 640 480"><path fill="#006a4e" d="M0 0h640v480H0z"/><circle cx="280" cy="240" r="130" fill="#f42a41"/></svg>' },
            { code: '+977', iso: 'np', name: 'Nepal', flag: '<svg viewBox="0 0 640 480"><path fill="#fff" d="M0 0h640v480H0z"/><path fill="#dc143c" stroke="#003893" stroke-width="24" d="M80 40 320 200H180l160 160H80z"/><circle cx="150" cy="130" r="25" fill="#fff"/><circle cx="150" cy="270" r="30" fill="#fff"/></svg>' },
            { code: '+60',  iso: 'my', name: 'Malaysia', flag: '<svg viewBox="0 0 640 480"><path fill="#cc0001" d="M0 0h640v480H0z"/><path stroke="#fff" stroke-width="34" d="M0 51h640M0 119h640M0 187h640M0 255h640M0 323h640M0 391h640M0 459h640"/><path fill="#000066" d="M0 0h320v272H0z"/><circle cx="160" cy="136" r="60" fill="#fc0"/><circle cx="180" cy="136" r="50" fill="#000066"/></svg>' },
            { code: '+974', iso: 'qa', name: 'Qatar', flag: '<svg viewBox="0 0 640 480"><path fill="#fff" d="M0 0h640v480H0z"/><path fill="#8d1b3d" d="m180 0 40 26.6-40 26.7 40 26.7-40 26.7 40 26.6-40 26.7 40 26.7-40 26.6 40 26.7-40 26.7 40 26.6-40 26.7 40 26.7-40 26.6 40 26.7H640V0z"/></svg>' },
            { code: '+965', iso: 'kw', name: 'Kuwait', flag: '<svg viewBox="0 0 640 480"><path fill="#007a3d" d="M0 0h640v160H0z"/><path fill="#fff" d="M0 160h640v160H0z"/><path fill="#ce1126" d="M0 320h640v160H0z"/><path fill="#000" d="m0 0 160 160v160L0 480z"/></svg>' },
            { code: '+968', iso: 'om', name: 'Oman', flag: '<svg viewBox="0 0 640 480"><path fill="#fff" d="M0 0h640v160H0z"/><path fill="#db161b" d="M0 160h640v160H0zM0 0h180v480H0z"/><path fill="#008000" d="M0 320h640v160H0z"/></svg>' },
            { code: '+49',  iso: 'de', name: 'Germany', flag: '<svg viewBox="0 0 640 480"><path fill="#000" d="M0 0h640v160H0z"/><path fill="#d00" d="M0 160h640v160H0z"/><path fill="#ffce00" d="M0 320h640v160H0z"/></svg>' },
            { code: '+33',  iso: 'fr', name: 'France', flag: '<svg viewBox="0 0 640 480"><path fill="#002395" d="M0 0h213.3v480H0z"/><path fill="#fff" d="M213.3 0h213.4v480H213.3z"/><path fill="#ed2939" d="M426.7 0H640v480H426.7z"/></svg>' },
            { code: '+64',  iso: 'nz', name: 'New Zealand', flag: '<svg viewBox="0 0 640 480"><path fill="#00247d" d="M0 0h640v480H0z"/><path fill="#fff" d="M0 0h320v240H0z"/><path fill="#cc142b" d="M130 0h60v240h-60zM0 90h320v60H0z"/><circle cx="480" cy="120" r="14" fill="#cc142b" stroke="#fff" stroke-width="4"/><circle cx="560" cy="200" r="14" fill="#cc142b" stroke="#fff" stroke-width="4"/><circle cx="480" cy="360" r="14" fill="#cc142b" stroke="#fff" stroke-width="4"/><circle cx="400" cy="230" r="12" fill="#cc142b" stroke="#fff" stroke-width="4"/></svg>' },
            { code: '+27',  iso: 'za', name: 'South Africa', flag: '<svg viewBox="0 0 640 480"><path fill="#000" d="M0 0h640v480H0z"/><path fill="#007a3d" d="M0 0h640v480H0z"/><path fill="#de3831" d="M200 0h440v160H200z"/><path fill="#002395" d="M200 320h440v160H200z"/><path fill="#000" d="M0 0 240 240 0 480z"/><path fill="#ffb612" stroke="#ffb612" stroke-width="12" d="M0 40 200 240 0 440z"/></svg>' }
        ];

        let selectedCountry = AQ_COUNTRY_DATA[0];

        function closeCountryDropdown() {
            var wrap = document.getElementById('login-country-picker-wrap');
            var btn = document.getElementById('login-country-btn');
            if (wrap) wrap.classList.remove('is-open');
            if (btn) btn.setAttribute('aria-expanded', 'false');
            var searchInp = document.getElementById('login-country-search-input');
            if (searchInp) {
                searchInp.value = '';
                filterCountryList('');
            }
        }

        function toggleCountryDropdown() {
            var wrap = document.getElementById('login-country-picker-wrap');
            var btn = document.getElementById('login-country-btn');
            if (!wrap) return;
            var isOpen = wrap.classList.toggle('is-open');
            if (btn) btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            if (isOpen) {
                var searchInp = document.getElementById('login-country-search-input');
                if (searchInp) {
                    searchInp.value = '';
                    filterCountryList('');
                    setTimeout(function() { searchInp.focus(); }, 80);
                }
            }
        }

        function selectCountry(country) {
            selectedCountry = country;
            var flagEl = document.getElementById('login-country-flag');
            var valEl = document.getElementById('login-country-val');
            var nativeSelect = document.getElementById('login-country-code');

            if (flagEl) flagEl.innerHTML = country.flag;
            if (valEl) valEl.textContent = country.code;

            if (nativeSelect) {
                var opt = Array.from(nativeSelect.options).find(function(o) { return o.value === country.code; });
                if (!opt) {
                    opt = new Option(country.name + ' (' + country.code + ')', country.code);
                    nativeSelect.add(opt);
                }
                nativeSelect.value = country.code;
                nativeSelect.dispatchEvent(new Event('change'));
            }

            renderCountryList();
            closeCountryDropdown();

            var phoneInput = document.getElementById('login-identifier-input');
            if (phoneInput) phoneInput.focus();
        }

        function filterCountryList(query) {
            var q = (query || '').toLowerCase().trim();
            var listEl = document.getElementById('login-country-list');
            if (!listEl) return;

            var filtered = AQ_COUNTRY_DATA.filter(function(c) {
                if (!q) return true;
                return c.name.toLowerCase().includes(q) || c.code.includes(q) || c.iso.includes(q);
            });

            if (filtered.length === 0) {
                listEl.innerHTML = '<li class="aq-country-empty">No country found</li>';
                return;
            }

            listEl.innerHTML = filtered.map(function(c) {
                var isSelected = (selectedCountry && selectedCountry.name === c.name && selectedCountry.code === c.code);
                return '<li class="aq-country-opt' + (isSelected ? ' is-selected' : '') + '" data-iso="' + c.iso + '">' +
                    '<div class="aq-country-opt-left">' +
                        '<span class="aq-country-flag">' + c.flag + '</span>' +
                        '<span class="aq-country-opt-name">' + c.name + '</span>' +
                    '</div>' +
                    '<div class="aq-country-opt-right">' +
                        '<span class="aq-country-opt-dial">' + c.code + '</span>' +
                        '<i class="fa-solid fa-check aq-country-opt-check"></i>' +
                    '</div>' +
                '</li>';
            }).join('');

            listEl.querySelectorAll('.aq-country-opt').forEach(function(item) {
                item.onclick = function(e) {
                    e.stopPropagation();
                    var iso = this.getAttribute('data-iso');
                    var c = AQ_COUNTRY_DATA.find(function(x) { return x.iso === iso; });
                    if (c) selectCountry(c);
                };
            });
        }

        function renderCountryList() {
            var searchInp = document.getElementById('login-country-search-input');
            var q = searchInp ? searchInp.value : '';
            filterCountryList(q);
        }

        function initCountryPicker() {
            var btn = document.getElementById('login-country-btn');
            if (btn) {
                btn.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleCountryDropdown();
                };
            }

            var searchInp = document.getElementById('login-country-search-input');
            if (searchInp) {
                searchInp.oninput = function() {
                    filterCountryList(this.value);
                };
                searchInp.onclick = function(e) {
                    e.stopPropagation();
                };
            }

            renderCountryList();
        }

        window.toggleIdentifierMode = function() {
            const input = document.getElementById('login-identifier-input');
            const label = document.getElementById('login-identifier-label');
            const countryPickerWrap = document.getElementById('login-country-picker-wrap');
            const countryCode = document.getElementById('login-country-code');
            const toggleLink = document.getElementById('toggle-login-mode-link');
            const group = document.getElementById('login-identifier-group');

            closeCountryDropdown();

            if (loginIdentifierMode === 'phone') {
                loginIdentifierMode = 'email';

                label.innerHTML = 'Email Address <span>*</span>';
                input.type = 'email';
                input.placeholder = 'Enter your email address';
                input.autocomplete = 'email';
                input.inputMode = 'email';
                if (countryPickerWrap) countryPickerWrap.style.display = 'none';
                if (countryCode) countryCode.hidden = true;
                if (group) group.classList.add('email-mode');
                toggleLink.textContent = 'Use Phone';
            } else {
                loginIdentifierMode = 'phone';

                label.innerHTML = 'Mobile Number <span>*</span>';
                input.type = 'tel';
                input.placeholder = 'Enter mobile number';
                input.autocomplete = 'tel-national';
                input.inputMode = 'tel';
                if (countryPickerWrap) countryPickerWrap.style.display = '';
                if (countryCode) countryCode.hidden = false;
                if (group) group.classList.remove('email-mode');
                toggleLink.textContent = 'Use Email';
            }

            input.value = '';
            input.focus();
        };

        window.autoFillStoreOtp = function() {
            var code = window.AUTH_FLOW_DATA.demo_otp || (document.getElementById('demo-otp-code') ? document.getElementById('demo-otp-code').textContent.trim() : '');
            if (!code) return;
            var inputs = document.querySelectorAll('#exampleModalToggle .otp-digit-input');
            for (var i = 0; i < inputs.length && i < code.length; i++) {
                inputs[i].value = code[i];
            }
        };

        window.resetAuthModalSteps = function() {
            clearInterval(resendInterval);
            hideLoginAlert();
            closeCountryDropdown();
            window.AUTH_FLOW_DATA = {
                flow: 'phone_first',
                email: '',
                phone: '',
                demo_otp: ''
            };

            if (loginIdentifierMode === 'email') {
                toggleIdentifierMode();
            }

            ['login-step-identifier', 'login-step-phone-for-email', 'login-step-otp', 'login-step-complete-email-name', 'login-step-complete-name'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) el.classList.add('d-none');
            });

            var s1 = document.getElementById('login-step-identifier');
            if (s1) s1.classList.remove('d-none');

            var tTitle = document.getElementById('login-modal-step-title');
            var tDesc = document.getElementById('login-modal-step-desc');
            if (tTitle) tTitle.textContent = 'Sign in to <?= $modal_store_name; ?>.';
            if (tDesc) tDesc.textContent = 'Enter your Mobile Number or Email to sign in or create an account with OTP.';

            var badge = document.getElementById('demo-otp-badge');
            if (badge) badge.style.display = 'none';

            var otpSub = document.getElementById('otp-email-sublabel');
            if (otpSub) otpSub.classList.add('d-none');
        };

        window.openLoginModal = function(redirectUrl, message) {
            if (redirectUrl) {
                window.REDIRECT_AFTER_LOGIN = redirectUrl;
                window.CUSTOM_REDIRECT_ACTIVE = true;
            } else {
                window.REDIRECT_AFTER_LOGIN = window.location.href;
                window.CUSTOM_REDIRECT_ACTIVE = false;
            }

            resetAuthModalSteps();

            if (message) {
                showLoginAlert('info', message);
            } else {
                hideLoginAlert();
            }

            var modalEl = document.getElementById('exampleModalToggle');
            if (modalEl) {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                } else if (typeof $ !== 'undefined' && $.fn.modal) {
                    $(modalEl).modal('show');
                }
                setTimeout(function() {
                    var inp = document.getElementById('login-identifier-input');
                    if (inp) inp.focus();
                }, 250);
            }
        };

        window.handleSendOtp = function(e) {
            if (e) e.preventDefault();

            const input = document.getElementById('login-identifier-input');
            const countryCode = document.getElementById('login-country-code');
            const btn = document.getElementById('btn-send-otp');

            const value = input.value.trim();
            const isEmail = loginIdentifierMode === 'email';

            if (!value) {
                input.reportValidity();
                return;
            }

            if (isEmail && !input.checkValidity()) {
                input.reportValidity();
                return;
            }

            let phoneDigits = value.replace(/\D/g, '');
            const selectedCode = (countryCode && countryCode.value) ? countryCode.value.trim() : (selectedCountry ? selectedCountry.code : '+91');
            const rawCode = selectedCode.replace(/\D/g, '');

            if (phoneDigits.startsWith('0')) {
                phoneDigits = phoneDigits.replace(/^0+/, '');
            }
            if (rawCode && phoneDigits.startsWith(rawCode) && phoneDigits.length > rawCode.length + 6) {
                phoneDigits = phoneDigits.slice(rawCode.length);
            }

            // Build the correct identifier.
            const identifier = isEmail ?
                value.toLowerCase() :
                selectedCode + phoneDigits;

            const formData = new FormData();
            formData.append('identifier', identifier);
            formData.append('type', isEmail ? 'email' : 'phone');

            hideLoginAlert();
            btn.disabled = true;
            btn.textContent = 'Sending OTP...';

            fetch('<?= site_url("auth/send_otp"); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) throw new Error('Request failed');
                    return res.json();
                })
                .then(data => {
                    if (!data.success) {
                        showLoginAlert(
                            'danger',
                            data.message || 'Failed to send OTP.'
                        );
                        return;
                    }

                    window.AUTH_FLOW_DATA.flow = isEmail ?
                        'email_first' :
                        'phone_first';

                    window.AUTH_FLOW_DATA.email = isEmail ? identifier : '';
                    window.AUTH_FLOW_DATA.phone = isEmail ? '' : identifier;
                    window.AUTH_FLOW_DATA.demo_otp = data.demo_otp || '';

                    document.getElementById('otp-target-label').textContent =
                        isEmail ? identifier : (data.phone || identifier);

                    const emailSub = document.getElementById('otp-email-sublabel');
                    emailSub.classList.add('d-none');

                    const demoBadge = document.getElementById('demo-otp-badge');
                    const demoCode = document.getElementById('demo-otp-code');

                    if (data.demo_otp) {
                        demoCode.textContent = data.demo_otp;
                        demoBadge.style.display = 'flex';
                    } else {
                        demoBadge.style.display = 'none';
                    }

                    document.getElementById('login-step-identifier')
                        .classList.add('d-none');

                    document.getElementById('login-step-otp')
                        .classList.remove('d-none');

                    document.getElementById('login-modal-step-title').textContent =
                        'Verify OTP';

                    document.getElementById('login-modal-step-desc').textContent =
                        isEmail ?
                        'Enter the 6-digit code sent to your email.' :
                        'Enter the 6-digit code sent to your mobile number.';

                    startResendTimer();
                    initOtpInputs();
                })
                .catch(() => {
                    showLoginAlert(
                        'danger',
                        'Network error occurred. Please try again.'
                    );
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = 'Continue with OTP';
                });
        };

        window.handlePhoneForEmail = function(e) {
            if (e && e.preventDefault) e.preventDefault();

            var phoneInput = document.getElementById('login-phone-input');
            var btnPhone = document.getElementById('btn-phone-for-email');
            var phone = phoneInput ? phoneInput.value.trim() : '';
            if (!phone) return;

            btnPhone.disabled = true;
            btnPhone.textContent = 'Sending OTP...';
            hideLoginAlert();

            var formData = new FormData();
            formData.append('identifier', phone);
            formData.append('email', window.AUTH_FLOW_DATA.email || '');

            fetch('<?= site_url("auth/send_otp"); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    btnPhone.disabled = false;
                    btnPhone.textContent = 'Continue with OTP';

                    if (data.success) {
                        window.AUTH_FLOW_DATA.phone = data.phone || phone;
                        window.AUTH_FLOW_DATA.demo_otp = data.demo_otp || '';
                        document.getElementById('otp-target-label').textContent = window.AUTH_FLOW_DATA.phone;

                        var emailSub = document.getElementById('otp-email-sublabel');
                        if (emailSub && window.AUTH_FLOW_DATA.email) {
                            emailSub.textContent = 'Email: ' + window.AUTH_FLOW_DATA.email;
                            emailSub.classList.remove('d-none');
                        }

                        var demoBadge = document.getElementById('demo-otp-badge');
                        var demoCode = document.getElementById('demo-otp-code');
                        if (data.demo_otp && demoBadge && demoCode) {
                            demoCode.textContent = data.demo_otp;
                            demoBadge.style.display = 'flex';
                        }

                        document.getElementById('login-step-phone-for-email').classList.add('d-none');
                        document.getElementById('login-step-otp').classList.remove('d-none');
                        document.getElementById('login-modal-step-title').textContent = 'Verify Mobile OTP';
                        document.getElementById('login-modal-step-desc').textContent = 'Enter the 6-digit code sent to ' + window.AUTH_FLOW_DATA.phone + '.';

                        startResendTimer();
                        initOtpInputs();
                    } else {
                        showLoginAlert('danger', data.message || 'Failed to send OTP.');
                    }
                })
                .catch(function() {
                    btnPhone.disabled = false;
                    btnPhone.textContent = 'Continue with OTP';
                    showLoginAlert('danger', 'Network error occurred. Please try again.');
                });
        };

        window.handleVerifyOtp = function(e) {
            if (e && e.preventDefault) e.preventDefault();

            var phone = window.AUTH_FLOW_DATA.phone || document.getElementById('otp-target-label').textContent.trim();
            var inputs = document.querySelectorAll('#exampleModalToggle .otp-digit-input');
            var otpCode = '';
            inputs.forEach(function(inp) {
                otpCode += inp.value.trim();
            });

            if (otpCode.length < 6) {
                showLoginAlert('warning', 'Please enter all 6 digits of the verification code.');
                return;
            }

            var btnVerify = document.getElementById('btn-verify-otp');
            btnVerify.disabled = true;
            btnVerify.textContent = 'Verifying...';
            hideLoginAlert();

            var formData = new FormData();
            formData.append('phone', phone);
            formData.append('otp', otpCode);
            formData.append('redirect_to', window.REDIRECT_AFTER_LOGIN || window.location.href);

            fetch('<?= site_url("auth/verify_otp"); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    btnVerify.disabled = false;
                    btnVerify.textContent = 'Verify & Continue';

                    if (data.success) {
                        if (data.status === 'logged_in') {
                            showLoginAlert('success', data.message || 'Login successful!');
                            window.IS_USER_LOGGED_IN = true;
                            setTimeout(function() {
                                window.location.href = data.redirect || window.location.href;
                            }, 500);
                        } else if (data.status === 'need_email_name') {
                            document.getElementById('login-step-otp').classList.add('d-none');
                            document.getElementById('login-step-complete-email-name').classList.remove('d-none');
                            document.getElementById('verified-phone-label-1').textContent = data.phone || phone;
                            document.getElementById('login-modal-step-title').textContent = 'Create Account';
                            document.getElementById('login-modal-step-desc').textContent = 'Please enter your name and email address to finish registration.';
                            setTimeout(function() {
                                var inp = document.getElementById('reg-name-1');
                                if (inp) inp.focus();
                            }, 200);
                        } else if (data.status === 'need_name') {
                            document.getElementById('login-step-otp').classList.add('d-none');
                            document.getElementById('login-step-complete-name').classList.remove('d-none');
                            document.getElementById('verified-email-label-2').textContent = data.email || window.AUTH_FLOW_DATA.email;
                            document.getElementById('verified-phone-label-2').textContent = data.phone || phone;
                            document.getElementById('login-modal-step-title').textContent = 'Create Account';
                            document.getElementById('login-modal-step-desc').textContent = 'Enter your full name to complete your registration.';
                            setTimeout(function() {
                                var inp = document.getElementById('reg-name-2');
                                if (inp) inp.focus();
                            }, 200);
                        }
                    } else {
                        showLoginAlert('danger', data.message || 'Invalid OTP code.');
                    }
                })
                .catch(function() {
                    btnVerify.disabled = false;
                    btnVerify.textContent = 'Verify & Continue';
                    showLoginAlert('danger', 'Verification error. Please try again.');
                });
        };

        window.handleCompleteEmailName = function(e) {
            if (e && e.preventDefault) e.preventDefault();

            var name = (document.getElementById('reg-name-1').value || '').trim();
            var email = (document.getElementById('reg-email-1').value || '').trim();
            var btn = document.getElementById('btn-complete-1');

            if (!name || !email) {
                showLoginAlert('warning', 'Please enter your name and a valid email address.');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Creating Account...';
            hideLoginAlert();

            var formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('redirect_to', window.REDIRECT_AFTER_LOGIN || window.location.href);

            fetch('<?= site_url("auth/complete_registration"); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    btn.disabled = false;
                    btn.textContent = 'Complete Registration & Login';
                    if (data.success) {
                        showLoginAlert('success', data.message || 'Account created!');
                        window.IS_USER_LOGGED_IN = true;
                        setTimeout(function() {
                            window.location.href = data.redirect || window.location.href;
                        }, 500);
                    } else {
                        showLoginAlert('danger', data.message || 'Registration failed.');
                    }
                });
        };

        window.handleCompleteName = function(e) {
            if (e && e.preventDefault) e.preventDefault();

            var name = (document.getElementById('reg-name-2').value || '').trim();
            var btn = document.getElementById('btn-complete-2');
            if (!name) {
                showLoginAlert('warning', 'Please enter your name.');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Creating Account...';
            hideLoginAlert();

            var formData = new FormData();
            formData.append('name', name);
            formData.append('email', window.AUTH_FLOW_DATA.email || '');
            formData.append('redirect_to', window.REDIRECT_AFTER_LOGIN || window.location.href);

            fetch('<?= site_url("auth/complete_registration"); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    btn.disabled = false;
                    btn.textContent = 'Complete Registration & Login';
                    if (data.success) {
                        showLoginAlert('success', data.message || 'Account created!');
                        window.IS_USER_LOGGED_IN = true;
                        setTimeout(function() {
                            window.location.href = data.redirect || window.location.href;
                        }, 500);
                    } else {
                        showLoginAlert('danger', data.message || 'Registration failed.');
                    }
                });
        };

        window.handleChangeFromOtp = function() {
            clearInterval(resendInterval);
            hideLoginAlert();
            document.getElementById('login-step-otp').classList.add('d-none');
            if (window.AUTH_FLOW_DATA && window.AUTH_FLOW_DATA.flow === 'email_first') {
                document.getElementById('login-step-phone-for-email').classList.remove('d-none');
            } else {
                backToIdentifierStep();
            }
        };

        window.backToIdentifierStep = function() {
            clearInterval(resendInterval);
            hideLoginAlert();
            ['login-step-phone-for-email', 'login-step-otp', 'login-step-complete-email-name', 'login-step-complete-name'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) el.classList.add('d-none');
            });
            document.getElementById('login-step-identifier').classList.remove('d-none');
            document.getElementById('login-modal-step-title').textContent = 'Sign in to <?= $modal_store_name; ?>.';
            document.getElementById('login-modal-step-desc').textContent = 'Enter your Mobile Number or Email to sign in or create an account with OTP.';
        };

        window.resendOtp = function() {
            var btn = document.getElementById('btn-resend-otp');
            if (!btn || btn.classList.contains('disabled')) return;
            var identifier = window.AUTH_FLOW_DATA.phone || document.getElementById('otp-target-label').textContent.trim();
            if (!identifier) return;

            var formData = new FormData();
            formData.append('identifier', identifier);
            if (window.AUTH_FLOW_DATA.email) {
                formData.append('email', window.AUTH_FLOW_DATA.email);
            }

            btn.classList.add('disabled');
            btn.textContent = 'Sending...';

            fetch('<?= site_url("auth/send_otp"); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    if (data.success) {
                        window.AUTH_FLOW_DATA.demo_otp = data.demo_otp || '';
                        if (data.demo_otp) {
                            var demoCode = document.getElementById('demo-otp-code');
                            if (demoCode) demoCode.textContent = data.demo_otp;
                        }
                        showLoginAlert('success', 'A new 6-digit OTP has been sent.');
                        startResendTimer();
                    } else {
                        showLoginAlert('danger', data.message || 'Failed to resend OTP.');
                        btn.classList.remove('disabled');
                        btn.textContent = 'Resend OTP';
                    }
                });
        };

        function startResendTimer() {
            var btn = document.getElementById('btn-resend-otp');
            if (!btn) return;
            var count = 30;
            btn.classList.add('disabled');
            btn.innerHTML = 'Resend in <span id="resend-timer-count">' + count + '</span>s';
            clearInterval(resendInterval);
            resendInterval = setInterval(function() {
                count--;
                var countEl = document.getElementById('resend-timer-count');
                if (countEl) countEl.textContent = count;
                if (count <= 0) {
                    clearInterval(resendInterval);
                    btn.classList.remove('disabled');
                    btn.textContent = 'Resend OTP';
                }
            }, 1000);
        }

        function initOtpInputs() {
            var inputs = document.querySelectorAll('#exampleModalToggle .otp-digit-input');
            inputs.forEach(function(input, index) {
                input.value = '';
                input.oninput = function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length >= 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                };
                input.onkeydown = function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                };
            });
            if (inputs.length > 0) {
                setTimeout(function() {
                    inputs[0].focus();
                }, 200);
            }
        }

        function showLoginAlert(type, msg) {
            var alertBox = document.getElementById('login-modal-alert');
            if (!alertBox) return;
            alertBox.className = 'alert alert-' + type + ' py-2 px-3 small rounded-3 mb-3';
            alertBox.textContent = msg;
            alertBox.classList.remove('d-none');
        }

        function hideLoginAlert() {
            var alertBox = document.getElementById('login-modal-alert');
            if (alertBox) alertBox.classList.add('d-none');
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCountryPicker);
        } else {
            initCountryPicker();
        }

        document.addEventListener('click', function(e) {
            var picker = document.getElementById('login-country-picker-wrap');
            if (picker && !picker.contains(e.target)) {
                closeCountryDropdown();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCountryDropdown();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Intercept any links pointing to auth/login or #loginModal when not logged in and open #exampleModalToggle
            document.addEventListener('click', function(e) {
                var trigger = e.target.closest('a[href*="/auth/login"], a[href="#loginModal"], a[href="#exampleModalToggle"]');
                if (trigger && !window.IS_USER_LOGGED_IN) {
                    e.preventDefault();
                    var redir = trigger.getAttribute('data-redirect-to') || window.location.href;
                    var msg = trigger.getAttribute('data-login-message') || '';
                    window.openLoginModal(redir, msg);
                }
            });
        });
    })();
</script>