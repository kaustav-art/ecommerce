<?php
$curr_tab = isset($active_tab) ? $active_tab : 'multi-theme';
$curr_layout = isset($active_layout) ? (int)$active_layout : 1;
$curr_sec = isset($active_section) ? $active_section : 'hero';
$curr_target_tpl = in_array($curr_tab, array('template1', 'template2')) ? $curr_tab : 'template2';
$root_url = rtrim(main_site_url(), '/') . '/';
$website_url_base = rtrim(tenant_site_url(), '/') . '/';

// Layout names for Template 1 and Template 2
if ($curr_target_tpl === 'template1') {
    $layout_names = array(
        1 => 'Home 1',
        2 => 'Home 2',
        3 => 'Home 3'
    );
} else {
    $layout_names = array(
        1 => 'Layout 1',
        2 => 'Layout 2',
        3 => 'Layout 3'
    );
}
?>
<!-- Summernote Lite CSS for Rich Text Editors -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
/* ============================================================
   Executive Dark Gold Theme for Summernote WYSIWYG Editor
   ============================================================ */
.note-editor.note-frame {
    border: 1px solid rgba(194, 153, 88, 0.35) !important;
    border-radius: 10px !important;
    overflow: hidden !important;
    background-color: #080d19 !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35) !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
}
.note-editor.note-frame.focus {
    border-color: #c29958 !important;
    box-shadow: 0 0 0 3px rgba(194, 153, 88, 0.25) !important;
}

/* Toolbar */
.note-editor.note-frame .note-toolbar {
    background-color: #0c1322 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    padding: 8px 10px !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 4px !important;
}
.note-editor.note-frame .note-toolbar .note-btn-group {
    margin-right: 4px !important;
    margin-bottom: 4px !important;
}

/* Toolbar Buttons (exclude color buttons so palette swatches work) */
.note-btn:not(.note-color-btn) {
    background-color: #111a2e !important;
    color: #e2e8f0 !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    border-radius: 6px !important;
    padding: 5px 10px !important;
    font-size: 13px !important;
    transition: all 0.15s ease !important;
}
.note-btn:not(.note-color-btn):hover,
.note-btn:not(.note-color-btn):focus {
    background-color: rgba(194, 153, 88, 0.2) !important;
    color: #fbbf24 !important;
    border-color: #c29958 !important;
    outline: none !important;
}
.note-btn:not(.note-color-btn).active,
.note-btn:not(.note-color-btn):active {
    background-color: #c29958 !important;
    color: #0c1322 !important;
    border-color: #c29958 !important;
    font-weight: 700 !important;
}
.note-btn .note-icon-caret {
    border-top-color: currentColor !important;
}

/* Dropdown Menus (Style, Font, Paragraph, Table, Color) */
.note-dropdown-menu,
.note-editor .dropdown-menu {
    background-color: #111a2e !important;
    border: 1px solid rgba(194, 153, 88, 0.35) !important;
    border-radius: 8px !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6) !important;
    padding: 6px 0 !important;
    z-index: 1065 !important;
}
.note-dropdown-menu a,
.note-dropdown-menu .dropdown-item,
.note-dropdown-item {
    color: #cbd5e1 !important;
    padding: 8px 16px !important;
    font-size: 13px !important;
    transition: all 0.15s ease !important;
    display: block !important;
    text-decoration: none !important;
    background: transparent !important;
}
.note-dropdown-menu a:hover,
.note-dropdown-menu a:focus,
.note-dropdown-menu .dropdown-item:hover,
.note-dropdown-menu .dropdown-item:focus,
.note-dropdown-item:hover {
    background-color: rgba(194, 153, 88, 0.2) !important;
    color: #fbbf24 !important;
}
.note-dropdown-menu h1,
.note-dropdown-menu h2,
.note-dropdown-menu h3,
.note-dropdown-menu h4,
.note-dropdown-menu h5,
.note-dropdown-menu h6,
.note-dropdown-menu p,
.note-dropdown-menu pre,
.note-dropdown-menu blockquote {
    color: #f1f5f9 !important;
    margin: 0 !important;
}
.note-dropdown-menu .note-check {
    display: none !important;
}

/* Color Palette Dropdown & Swatches */
.note-color .note-dropdown-menu,
.note-color-all .note-dropdown-menu,
.note-popover .popover-content .note-color .note-dropdown-menu {
    min-width: 350px !important;
    padding: 12px 14px !important;
    background-color: #111a2e !important;
    border: 1px solid rgba(194, 153, 88, 0.4) !important;
    border-radius: 8px !important;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.7) !important;
}
.note-color .note-palette,
.note-color-all .note-palette {
    display: inline-block !important;
    vertical-align: top !important;
    width: 155px !important;
    margin: 0 4px !important;
}
.note-color-palette {
    line-height: 1 !important;
    padding: 4px 0 !important;
}
.note-color-palette .note-color-row {
    display: flex !important;
    height: 18px !important;
    margin-bottom: 2px !important;
}
.note-color-palette .note-color-btn {
    width: 18px !important;
    height: 18px !important;
    min-width: 18px !important;
    max-width: 18px !important;
    padding: 0 !important;
    margin: 1px !important;
    border: 1px solid rgba(0, 0, 0, 0.25) !important;
    border-radius: 2px !important;
    cursor: pointer !important;
    box-sizing: border-box !important;
    display: inline-block !important;
    transition: transform 0.12s ease !important;
}
.note-color-palette .note-color-btn:hover {
    transform: scale(1.3) !important;
    z-index: 10 !important;
    border-color: #ffffff !important;
    box-shadow: 0 0 6px rgba(251, 191, 36, 0.9) !important;
}
.note-palette-title {
    color: #fbbf24 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.12) !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    margin: 2px 0 6px 0 !important;
    padding-bottom: 4px !important;
    text-align: center !important;
}
.note-color-reset,
.note-color-select {
    display: block !important;
    width: 100% !important;
    background-color: #0c1322 !important;
    color: #cbd5e1 !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
    border-radius: 4px !important;
    padding: 5px 8px !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    margin: 4px 0 !important;
    cursor: pointer !important;
    text-align: center !important;
    transition: all 0.15s ease !important;
}
.note-color-reset:hover,
.note-color-select:hover {
    background-color: rgba(194, 153, 88, 0.25) !important;
    color: #fbbf24 !important;
    border-color: #c29958 !important;
}

/* Table Dimension Picker */
.note-dimension-picker-mousecatcher {
    background-color: transparent !important;
}
.note-dimension-picker-unhighlighted {
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    background-color: #080d19 !important;
}
.note-dimension-picker-highlighted {
    border: 1px solid #c29958 !important;
    background-color: rgba(194, 153, 88, 0.35) !important;
}

/* Editable Area */
.note-editor.note-frame .note-editing-area {
    background-color: #080d19 !important;
    color: #f1f5f9 !important;
}
.note-editor.note-frame .note-editable {
    color: #f1f5f9 !important;
    background-color: #080d19 !important;
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
    font-size: 15px !important;
    line-height: 1.8 !important;
    padding: 16px 20px !important;
    min-height: 250px !important;
}
.note-editor.note-frame .note-editable p {
    color: #cbd5e1 !important;
    margin-bottom: 1rem !important;
    line-height: 1.8 !important;
}
.note-editor.note-frame .note-editable h1,
.note-editor.note-frame .note-editable h2,
.note-editor.note-frame .note-editable h3,
.note-editor.note-frame .note-editable h4,
.note-editor.note-frame .note-editable h5,
.note-editor.note-frame .note-editable h6 {
    color: #ffffff !important;
    margin-top: 1.5rem !important;
    margin-bottom: 0.75rem !important;
    font-weight: 700 !important;
}
.note-editor.note-frame .note-editable ul {
    list-style-type: disc !important;
    padding-left: 28px !important;
    margin-top: 0.5rem !important;
    margin-bottom: 1.25rem !important;
}
.note-editor.note-frame .note-editable ol {
    list-style-type: decimal !important;
    padding-left: 28px !important;
    margin-top: 0.5rem !important;
    margin-bottom: 1.25rem !important;
}
.note-editor.note-frame .note-editable li {
    display: list-item !important;
    color: #cbd5e1 !important;
    margin-bottom: 6px !important;
    line-height: 1.7 !important;
}
.note-editor.note-frame .note-editable blockquote {
    border-left: 4px solid #c29958 !important;
    background-color: rgba(255, 255, 255, 0.03) !important;
    padding: 12px 18px !important;
    margin: 1.25rem 0 !important;
    font-style: italic !important;
    color: #94a3b8 !important;
    border-radius: 0 6px 6px 0 !important;
}
.note-editor.note-frame .note-editable a {
    color: #fbbf24 !important;
    text-decoration: underline !important;
}
.note-editor.note-frame .note-editable table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
}
.note-editor.note-frame .note-editable table td,
.note-editor.note-frame .note-editable table th {
    border: 1px solid rgba(255, 255, 255, 0.15);
    padding: 8px 12px;
    color: #e2e8f0;
}
/* Complete border removal for borderless tables in Editor */
.note-editor.note-frame .note-editable table.table-borderless,
.note-editor.note-frame .note-editable table.no-border,
.note-editor.note-frame .note-editable table[data-borderless="1"],
.note-editor.note-frame .note-editable table[style*="border: none"],
.note-editor.note-frame .note-editable table[style*="border:none"],
.note-editor.note-frame .note-editable table.table-borderless *,
.note-editor.note-frame .note-editable table.no-border *,
.note-editor.note-frame .note-editable table[data-borderless="1"] *,
.note-editor.note-frame .note-editable table[style*="border: none"] *,
.note-editor.note-frame .note-editable table[style*="border:none"] * {
    border: 0 !important;
    border-top: 0 !important;
    border-bottom: 0 !important;
    border-left: 0 !important;
    border-right: 0 !important;
    box-shadow: none !important;
}
.note-editor.note-frame .note-placeholder {
    color: #64748b !important;
    padding: 16px 20px !important;
    font-size: 14px !important;
}

/* Statusbar & Resizer */
.note-editor.note-frame .note-statusbar {
    background-color: #0c1322 !important;
    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
    padding: 4px 8px !important;
}
.note-editor.note-frame .note-statusbar .note-resizebar {
    padding-top: 2px !important;
}
.note-editor.note-frame .note-statusbar .note-resizebar .note-icon-bar {
    border-top: 1px solid rgba(194, 153, 88, 0.5) !important;
    width: 24px !important;
    margin: 1px auto !important;
}

/* Summernote Modals & Dialogs (Insert Link, Picture, Video, Help) */
.note-modal-backdrop {
    display: none !important;
    pointer-events: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
    width: 0 !important;
    height: 0 !important;
    z-index: -9999 !important;
}
.note-modal {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 1065 !important;
    overflow-x: hidden !important;
    overflow-y: auto !important;
    background-color: rgba(4, 7, 14, 0.75) !important;
    backdrop-filter: blur(4px) !important;
    display: none !important;
}
.note-modal.open {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
.note-modal-content,
.note-modal .note-modal-content,
.note-modal .modal-content {
    background-color: #111a2e !important;
    background: #111a2e !important;
    border: 1px solid rgba(194, 153, 88, 0.45) !important;
    border-radius: 12px !important;
    color: #f1f5f9 !important;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.85) !important;
    width: 90% !important;
    max-width: 520px !important;
    margin: auto !important;
    overflow: hidden !important;
    position: relative !important;
}
.note-modal-header,
.note-modal .note-modal-header,
.note-modal .modal-header {
    background-color: #0c1322 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    padding: 14px 22px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}
.note-modal-title,
.note-modal .note-modal-title,
.note-modal .modal-title {
    color: #ffffff !important;
    font-size: 16px !important;
    font-weight: 700 !important;
    margin: 0 !important;
    letter-spacing: 0.3px !important;
}
.note-modal .close,
.note-modal-header .close,
.note-modal .note-close {
    background: transparent !important;
    border: 0 !important;
    color: #94a3b8 !important;
    font-size: 20px !important;
    cursor: pointer !important;
    padding: 0 !important;
    margin: 0 !important;
    line-height: 1 !important;
    opacity: 0.8 !important;
    transition: color 0.15s ease, opacity 0.15s ease !important;
}
.note-modal .close:hover,
.note-modal-header .close:hover,
.note-modal .note-close:hover {
    color: #fbbf24 !important;
    opacity: 1 !important;
}
/* Ensure every form modal has smooth scrollable body with overflow-y: auto */
.modal-dialog:not(.modal-fullscreen) {
    max-height: calc(100vh - 3rem);
}
.modal-content > form,
.modal form {
    display: flex;
    flex-direction: column;
    max-height: calc(100vh - 3.5rem);
    height: 100%;
    overflow: hidden;
}
.modal-content > form .modal-header,
.modal form .modal-header,
.modal-header {
    flex-shrink: 0 !important;
}
.modal-content > form .modal-footer,
.modal form .modal-footer,
.modal-footer {
    flex-shrink: 0 !important;
}
.modal-dialog:not(.modal-fullscreen) .modal-body,
.modal-content > form .modal-body,
.modal form .modal-body,
.modal-dialog-scrollable .modal-body {
    overflow-y: auto !important;
    max-height: calc(100vh - 210px);
}
#modalPreviewLayout .modal-body {
    overflow: hidden !important;
    max-height: none !important;
}

.note-modal-body,
.note-modal .note-modal-body,
.note-modal .modal-body {
    background-color: #111a2e !important;
    background: #111a2e !important;
    padding: 22px !important;
    color: #cbd5e1 !important;
    overflow-y: auto !important;
    max-height: calc(100vh - 210px);
}
.note-modal .note-form-group,
.note-modal .form-group {
    margin-bottom: 16px !important;
}
.note-modal .note-form-label,
.note-modal-body label,
.note-modal label {
    color: #f1f5f9 !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    margin-bottom: 6px !important;
    display: block !important;
}
.note-modal .note-input,
.note-modal .note-form-control,
.note-modal input[type="text"],
.note-modal input[type="file"],
.note-modal select,
.note-modal textarea {
    background-color: #080d19 !important;
    background: #080d19 !important;
    border: 1px solid rgba(255, 255, 255, 0.18) !important;
    color: #ffffff !important;
    border-radius: 6px !important;
    padding: 9px 12px !important;
    font-size: 13.5px !important;
    width: 100% !important;
    box-sizing: border-box !important;
    transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
}
.note-modal .note-input:focus,
.note-modal input[type="text"]:focus,
.note-modal .note-form-control:focus {
    border-color: #c29958 !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(194, 153, 88, 0.25) !important;
    background-color: #0c1322 !important;
}
.note-modal input[type="file"] {
    color: #cbd5e1 !important;
    padding: 8px 10px !important;
}
.note-modal input[type="file"]::file-selector-button {
    background-color: #111a2e !important;
    color: #fbbf24 !important;
    border: 1px solid rgba(194, 153, 88, 0.45) !important;
    border-radius: 5px !important;
    padding: 4px 12px !important;
    margin-right: 10px !important;
    font-weight: 600 !important;
    font-size: 12px !important;
    cursor: pointer !important;
    transition: all 0.15s ease !important;
}
.note-modal input[type="file"]::file-selector-button:hover {
    background-color: #c29958 !important;
    color: #0c1322 !important;
}
.note-modal .note-dropzone,
.note-modal .note-image-dialog .note-dropzone {
    min-height: 90px !important;
    font-size: 15px !important;
    line-height: 90px !important;
    color: #94a3b8 !important;
    text-align: center !important;
    border: 2px dashed rgba(194, 153, 88, 0.45) !important;
    border-radius: 8px !important;
    background-color: rgba(8, 13, 25, 0.6) !important;
    margin-bottom: 14px !important;
    transition: all 0.2s ease !important;
}
.note-modal .note-dropzone:hover {
    border-color: #fbbf24 !important;
    color: #fbbf24 !important;
    background-color: rgba(194, 153, 88, 0.1) !important;
}
.note-modal .checkbox {
    margin: 12px 0 6px 0 !important;
}
.note-modal .checkbox label {
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    color: #cbd5e1 !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    cursor: pointer !important;
}
.note-modal .checkbox input[type="checkbox"] {
    accent-color: #c29958 !important;
    width: 16px !important;
    height: 16px !important;
    cursor: pointer !important;
    margin: 0 !important;
}
.note-modal-footer,
.note-modal .note-modal-footer,
.note-modal .modal-footer {
    background-color: #0c1322 !important;
    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
    padding: 14px 24px !important;
    height: auto !important;
    display: flex !important;
    justify-content: flex-end !important;
    align-items: center !important;
    gap: 10px !important;
}
.note-modal .note-btn-primary,
.note-modal .note-image-btn,
.note-modal .note-link-btn,
.note-modal .note-video-btn,
.note-modal .btn-primary {
    background-color: #c29958 !important;
    border: 1px solid #c29958 !important;
    color: #0c1322 !important;
    font-weight: 700 !important;
    font-size: 13px !important;
    border-radius: 6px !important;
    padding: 8px 20px !important;
    cursor: pointer !important;
    transition: all 0.15s ease !important;
    text-decoration: none !important;
    display: inline-block !important;
}
.note-modal .note-btn-primary:hover:not(:disabled),
.note-modal .note-image-btn:hover:not(:disabled),
.note-modal .note-link-btn:hover:not(:disabled),
.note-modal .note-video-btn:hover:not(:disabled),
.note-modal .btn-primary:hover:not(:disabled) {
    background-color: #e5c388 !important;
    border-color: #e5c388 !important;
    color: #080d19 !important;
    box-shadow: 0 4px 14px rgba(194, 153, 88, 0.4) !important;
}
.note-modal .note-btn-primary:disabled,
.note-modal .note-image-btn:disabled,
.note-modal .note-link-btn:disabled,
.note-modal .note-video-btn:disabled,
.note-modal .btn-primary:disabled,
.note-modal .note-btn-primary.disabled,
.note-modal .note-image-btn.disabled,
.note-modal .note-link-btn.disabled,
.note-modal .note-video-btn.disabled {
    background-color: rgba(194, 153, 88, 0.25) !important;
    border-color: rgba(194, 153, 88, 0.25) !important;
    color: rgba(255, 255, 255, 0.35) !important;
    cursor: not-allowed !important;
    box-shadow: none !important;
}
.note-modal .help-list-item {
    color: #cbd5e1 !important;
    padding: 4px 6px !important;
    border-radius: 4px !important;
}
.note-modal .help-list-item:hover {
    background-color: rgba(194, 153, 88, 0.15) !important;
}
.note-modal .note-modal-body kbd {
    background-color: #080d19 !important;
    color: #fbbf24 !important;
    border: 1px solid rgba(194, 153, 88, 0.4) !important;
    padding: 2px 6px !important;
    border-radius: 4px !important;
    font-size: 11px !important;
}

/* Summernote Popovers & Tooltips */
.note-popover,
.note-popover .popover-content,
.note-popover .popover-body {
    background-color: #111a2e !important;
    border: 1px solid rgba(194, 153, 88, 0.35) !important;
    border-radius: 8px !important;
    color: #e2e8f0 !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5) !important;
    z-index: 1065 !important;
}

/* Codeview Mode */
.note-editor.note-frame .note-codable {
    background-color: #060a12 !important;
    color: #38bdf8 !important;
    font-family: 'JetBrains Mono', Consolas, monospace !important;
    border: none !important;
    padding: 16px 20px !important;
}

.layout-preview-thumb:hover .layout-thumb-img {
    transform: scale(1.05);
}
.layout-preview-thumb:hover .layout-thumb-overlay {
    opacity: 1 !important;
}
</style>

<div class="container-fluid px-4 py-4">
    <!-- Top Action Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-warning text-dark fw-bold font-monospace px-2 py-1">THEME ARCHITECTURE &amp; CMS</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">LIVE CUSTOMIZER</span>
            </div>
            <h3 class="fw-bold text-white mb-0 font-serif">Configure Layouts &amp; Template Customizer</h3>
            <p class="text-muted small mb-0">Fine-tune <?= $curr_target_tpl === 'template1' ? 'Template 1 (Home 1, 2, 3)' : 'Template 2 (Layouts 1, 2, and 3)' ?> dynamic sections, services, blogs, testimonials, and manage multi-theme layouts.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <div class="btn-group shadow-sm">
                <a href="<?= tenant_site_url('?preview_tpl=' . $curr_target_tpl . '&preview_layout=1') ?>" target="_blank" class="btn btn-outline-warning btn-sm fw-bold">
                    <i class="fa-solid fa-eye me-1"></i> Preview <?= $curr_target_tpl === 'template1' ? 'Home 1' : 'Layout 1' ?>
                </a>
                <a href="<?= tenant_site_url('?preview_tpl=' . $curr_target_tpl . '&preview_layout=2') ?>" target="_blank" class="btn btn-outline-warning btn-sm fw-bold">
                    <i class="fa-solid fa-eye me-1"></i> <?= $curr_target_tpl === 'template1' ? 'Home 2' : 'Layout 2' ?>
                </a>
                <a href="<?= tenant_site_url('?preview_tpl=' . $curr_target_tpl . '&preview_layout=3') ?>" target="_blank" class="btn btn-outline-warning btn-sm fw-bold">
                    <i class="fa-solid fa-eye me-1"></i> <?= $curr_target_tpl === 'template1' ? 'Home 3' : 'Layout 3' ?>
                </a>
            </div>
            <a href="<?= superadmin_url('website') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                <i class="fa-solid fa-globe me-1"></i> Product Landing CMS
            </a>
        </div>
    </div>

    <!-- Flash message alerts -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4) !important;">
            <i class="fa-solid fa-circle-check me-2"></i><?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Main Navigation Tabs -->
    <ul class="nav nav-pills gap-2 mb-4 p-2 rounded-3 border border-secondary border-opacity-25" style="background: #0c1322;">
        <li class="nav-item">
            <a class="nav-link <?= in_array($curr_tab, array('multi-theme', 'architecture')) ? 'active' : '' ?>" href="<?= superadmin_url('layouts?tab=multi-theme') ?>">
                <i class="fa-solid fa-layer-group text-info me-1"></i> Multi-Theme Architecture &amp; Layouts Manager
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $curr_tab === 'template1' ? 'active' : '' ?>" href="<?= superadmin_url('layouts?tab=template1&layout=' . ($curr_tab === 'template1' ? $curr_layout : 1)) ?>">
                <i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> Template 1 Customizer (Home 1, 2, 3)
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $curr_tab === 'template2' ? 'active' : '' ?>" href="<?= superadmin_url('layouts?tab=template2&layout=' . ($curr_tab === 'template2' ? $curr_layout : 1)) ?>">
                <i class="fa-solid fa-palette text-warning me-1"></i> Template 2 Customizer (Layouts 1, 2, 3)
            </a>
        </li>
    </ul>

    <!-- ======================================================== -->
    <!-- TAB 1: MULTI-THEME ARCHITECTURE & LAYOUTS MANAGER        -->
    <!-- ======================================================== -->
    <?php if ($curr_tab === 'multi-theme' || $curr_tab === 'architecture'): ?>
        <!-- Section Header Settings Card -->
        <form action="<?= superadmin_url('layouts') ?>" method="post" class="mb-4">
            <input type="hidden" name="action" value="save_theme_section">
            <input type="hidden" name="active_tab" value="multi-theme">

            <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(255,255,255,0.08) !important;">
                <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                    <h5 class="text-white fw-bold mb-0">
                        <i class="fa-solid fa-heading text-warning me-2"></i>Multi-Theme Public Heading &amp; Copy
                    </h5>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">
                        <i class="fa-solid fa-check me-1"></i> Save Section Copy
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Section Badge Text</label>
                            <input type="text" name="landing_templates_badge" class="form-control" value="<?= htmlspecialchars(get_setting('landing_templates_badge', 'Multi-Theme Architecture')) ?>" placeholder="Multi-Theme Architecture">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label text-white small fw-bold">Section Title Heading</label>
                            <input type="text" name="landing_templates_title" class="form-control" value="<?= htmlspecialchars(get_setting('landing_templates_title', 'Two World-Class Templates Included')) ?>" placeholder="Two World-Class Templates Included">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Section Subtitle / Description</label>
                            <textarea name="landing_templates_subtitle" class="form-control" rows="2"><?= htmlspecialchars(get_setting('landing_templates_subtitle', 'No need to purchase extra themes. Both premium templates with 6 total homepage layouts are bundled directly into the script package!')) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Dynamic Templates & Layouts Manager -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="text-white fw-bold mb-0"><i class="fa-solid fa-layer-group text-warning me-2"></i>Registered Templates &amp; Layouts</h5>
                <p class="text-muted small mb-0">Manage website templates, their descriptions, individual homepage layouts, and preview images.</p>
            </div>
            <button type="button" class="btn btn-gold fw-bold btn-sm px-3 shadow" data-bs-toggle="modal" data-bs-target="#modalTemplate" onclick="openNewTemplateModal()">
                <i class="fa-solid fa-plus me-1"></i> Add New Template
            </button>
        </div>

        <!-- Templates List -->
        <?php if (!empty($templates)): ?>
            <?php foreach ($templates as $t): ?>
                <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.25) !important;">
                    <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-dark border border-secondary text-warning font-monospace px-2 py-1">
                                <i class="<?= htmlspecialchars($t->icon ?: 'fa-solid fa-crown') ?> me-1"></i> <?= htmlspecialchars($t->template_key) ?>
                            </span>
                            <h5 class="text-white fw-bold mb-0 font-serif"><?= htmlspecialchars($t->name) ?></h5>
                            <?php if (!empty($t->badge)): ?>
                                <span class="badge bg-warning text-dark fw-bold"><?= htmlspecialchars($t->badge) ?></span>
                            <?php endif; ?>
                            <span class="badge <?= $t->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary' ?> small">
                                <?= ucfirst($t->status) ?>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-warning btn-sm fw-semibold" 
                                    onclick="openNewLayoutModal(<?= $t->id ?>, '<?= htmlspecialchars($t->template_key) ?>', '<?= htmlspecialchars(addslashes($t->name)) ?>', <?= count($t->layouts) + 1 ?>)">
                                <i class="fa-solid fa-plus me-1"></i> Add Layout
                            </button>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-light btn-sm fw-semibold" 
                                        onclick="openEditTemplateModal(<?= htmlspecialchars(json_encode($t)) ?>)">
                                    <i class="fa-solid fa-pencil me-1"></i> Edit Template
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                        onclick="deleteTemplate(<?= (int)$t->id ?>)" title="Delete Template">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Template Meta Info -->
                        <div class="p-3 rounded-3 mb-4" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.06);">
                            <div class="row g-2">
                                <div class="col-lg-8">
                                    <div class="small text-muted text-uppercase fw-bold mb-1">Short Description</div>
                                    <p class="text-light mb-0 small"><?= htmlspecialchars($t->short_desc) ?: '<em class="text-muted">No description provided.</em>' ?></p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="small text-muted text-uppercase fw-bold mb-1">Feature Badges</div>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php 
                                            $features = !empty($t->features) ? json_decode($t->features, true) : array();
                                            if (!empty($features)):
                                                foreach ($features as $f): ?>
                                                    <span class="badge bg-dark border border-secondary text-light small"><i class="fa fa-check text-success me-1"></i><?= htmlspecialchars($f) ?></span>
                                                <?php endforeach;
                                            else: ?>
                                                <span class="text-muted small">None configured</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Layouts Grid -->
                        <h6 class="text-white fw-bold mb-3 font-serif">
                            <i class="fa-solid fa-table-cells text-warning me-1"></i> Configured Layouts (<?= count($t->layouts) ?>)
                        </h6>

                        <?php if (!empty($t->layouts)): ?>
                            <div class="row g-3">
                                <?php foreach ($t->layouts as $l): ?>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="card h-100 border-0 rounded-3 overflow-hidden shadow-sm" style="background: #080d19; border: 1px solid rgba(255,255,255,0.08) !important;">
                                            <!-- Preview Image Box -->
                                            <div class="position-relative layout-preview-thumb" 
                                                 style="height: 165px; background: #000; overflow: hidden; cursor: pointer;"
                                                 onclick="openLayoutPreviewModal(<?= htmlspecialchars(json_encode($l)) ?>, '<?= htmlspecialchars(addslashes($t->name)) ?>')"
                                                 title="Click to preview layout">
                                                <img src="<?= htmlspecialchars(fallback_image_url($l->preview_image)) ?>" 
                                                     alt="<?= htmlspecialchars($l->layout_name) ?>" 
                                                     class="w-100 h-100 layout-thumb-img" 
                                                     style="object-fit: cover; transition: transform 0.3s ease;"
                                                     onerror="this.onerror=null;this.src='<?= main_site_url('uploads/no-image.jpg') ?>';">
                                                
                                                <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 border border-secondary text-warning fw-bold">
                                                    Layout <?= $l->layout_number ?>
                                                </span>

                                                <!-- Hover Overlay -->
                                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center layout-thumb-overlay" 
                                                     style="background: rgba(0,0,0,0.65); opacity: 0; transition: opacity 0.2s ease;">
                                                    <span class="badge bg-warning text-dark fw-bold px-3 py-2 shadow">
                                                        <i class="fa-solid fa-eye me-1"></i> Preview Layout
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="card-body p-3 d-flex flex-column">
                                                <div class="d-flex align-items-start justify-content-between mb-2">
                                                    <h6 class="text-white fw-bold mb-0 font-serif text-truncate" title="<?= htmlspecialchars($l->layout_name) ?>">
                                                        <?= htmlspecialchars($l->layout_name) ?>
                                                    </h6>
                                                    <span class="badge <?= $l->status === 'active' ? 'bg-success' : 'bg-secondary' ?> small">
                                                        <?= ucfirst($l->status) ?>
                                                    </span>
                                                </div>

                                                <div class="small text-muted font-monospace text-truncate mb-3" title="<?= htmlspecialchars($l->demo_url) ?>">
                                                    <i class="fa-solid fa-link me-1"></i> <?= htmlspecialchars($l->demo_url) ?>
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top border-secondary border-opacity-25">
                                                    <button type="button" class="btn btn-outline-warning btn-sm fw-bold" 
                                                            onclick="openLayoutPreviewModal(<?= htmlspecialchars(json_encode($l)) ?>, '<?= htmlspecialchars(addslashes($t->name)) ?>')">
                                                        <i class="fa-solid fa-expand me-1"></i> Preview
                                                    </button>
                                                    
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-light btn-sm fw-semibold" 
                                                                onclick="openEditLayoutModal(<?= htmlspecialchars(json_encode($l)) ?>, '<?= htmlspecialchars(addslashes($t->name)) ?>')">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                                                onclick="deleteLayout(<?= (int)$l->id ?>)" title="Delete Layout">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="fa-solid fa-layer-group fa-2x mb-2 text-secondary"></i>
                                <p class="mb-0">No layouts configured for this template yet. Click "Add Layout" to create one.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; /* End Tab 1: Multi-Theme Architecture */ ?>


    <!-- ======================================================== -->
    <!-- TAB 2: TEMPLATE CUSTOMIZER (TEMPLATE 1 & TEMPLATE 2)   -->
    <!-- ======================================================== -->
    <?php if ($curr_tab === 'template1' || $curr_tab === 'template2'): ?>

        <!-- Layout Selector Pills -->
        <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.25) !important;">
            <div class="card-body p-3">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-white-50 small text-uppercase fw-bold"><i class="fa-solid fa-sliders text-warning me-1"></i> Active Layout:</span>
                        <div class="btn-group">
                            <?php foreach ($layout_names as $l_num => $l_title): ?>
                                <a href="<?= superadmin_url('layouts?tab=' . $curr_target_tpl . '&layout=' . $l_num . '&section=' . $curr_sec) ?>" 
                                   class="btn btn-sm <?= $curr_layout === $l_num ? 'btn-warning fw-bold text-dark' : 'btn-outline-secondary text-light' ?>">
                                    <?= htmlspecialchars($l_title) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-dark border border-secondary text-warning">
                            Currently Editing: <?= htmlspecialchars($layout_names[$curr_layout]) ?> (<?= strtoupper($curr_target_tpl) ?>)
                        </span>
                        <a href="<?= tenant_site_url('?preview_tpl=' . $curr_target_tpl . '&preview_layout=' . $curr_layout) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Live View <?= $curr_target_tpl === 'template1' ? ('Home ' . $curr_layout) : ('Layout ' . $curr_layout) ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Navigation Pills for Current Layout -->
        <ul class="nav nav-tabs border-secondary border-opacity-25 mb-4">
            <li class="nav-item">
                <a class="nav-link <?= $curr_sec === 'hero' ? 'active text-warning fw-bold border-warning' : 'text-light' ?>" 
                   href="<?= superadmin_url('layouts?tab=' . $curr_target_tpl . '&layout=' . $curr_layout . '&section=hero') ?>">
                    <i class="fa-solid fa-bullhorn me-1"></i> Hero Banner
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $curr_sec === 'skincare' ? 'active text-warning fw-bold border-warning' : 'text-light' ?>" 
                   href="<?= superadmin_url('layouts?tab=' . $curr_target_tpl . '&layout=' . $curr_layout . '&section=skincare') ?>">
                    <i class="fa-solid fa-sparkles me-1"></i> <?= $curr_layout === 2 ? 'Our Works' : ($curr_layout === 1 ? 'Featured Highlights' : 'Features') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $curr_sec === 'about' ? 'active text-warning fw-bold border-warning' : 'text-light' ?>" 
                   href="<?= superadmin_url('layouts?tab=' . $curr_target_tpl . '&layout=' . $curr_layout . '&section=about') ?>">
                    <i class="fa-solid fa-address-card me-1"></i> About Us
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $curr_sec === 'services' ? 'active text-warning fw-bold border-warning' : 'text-light' ?>" 
                   href="<?= superadmin_url('layouts?tab=' . $curr_target_tpl . '&layout=' . $curr_layout . '&section=services') ?>">
                    <i class="fa-solid fa-hand-holding-heart me-1"></i> Services
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $curr_sec === 'testimonials' ? 'active text-warning fw-bold border-warning' : 'text-light' ?>" 
                   href="<?= superadmin_url('layouts?tab=' . $curr_target_tpl . '&layout=' . $curr_layout . '&section=testimonials') ?>">
                    <i class="fa-solid fa-comments me-1"></i> Testimonials
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $curr_sec === 'faqs' ? 'active text-warning fw-bold border-warning' : 'text-light' ?>" 
                   href="<?= superadmin_url('layouts?tab=' . $curr_target_tpl . '&layout=' . $curr_layout . '&section=faqs') ?>">
                    <i class="fa-solid fa-circle-question me-1"></i> FAQ's
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $curr_sec === 'blogs' ? 'active text-warning fw-bold border-warning' : 'text-light' ?>" 
                   href="<?= superadmin_url('layouts?tab=' . $curr_target_tpl . '&layout=' . $curr_layout . '&section=blogs') ?>">
                    <i class="fa-solid fa-newspaper me-1"></i> Blog
                </a>
            </li>
        </ul>

        <!-- ============================================== -->
        <!-- 1. HERO BANNER SECTION (MULTI-SLIDE CAROUSEL)  -->
        <!-- ============================================== -->
        <?php if ($curr_sec === 'hero'): ?>
            <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(255,255,255,0.08) !important;">
                <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h5 class="text-white fw-bold mb-1">
                            <i class="fa-solid fa-bullhorn text-warning me-2"></i>Hero Banner Slides &bull; <?= htmlspecialchars($layout_names[$curr_layout]) ?>
                        </h5>
                        <div class="small text-muted">
                            Manage multiple slides for the hero section. <?= $curr_layout === 1 ? 'These slides automatically rotate as a full-screen animated Swiper carousel on Layout 1.' : 'Layout ' . $curr_layout . ' displays the first active slide as its hero presentation.' ?>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalHeroSlide" onclick="openNewHeroSlideModal()">
                        <i class="fa-solid fa-plus me-1"></i> Add New Hero Slide
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0" style="background: transparent;">
                            <thead>
                                <tr class="text-secondary small text-uppercase">
                                    <th style="width: 70px;" class="ps-4"># Order</th>
                                    <th style="width: 110px;">Visual</th>
                                    <th style="width: 280px;">Tagline & Title</th>
                                    <th>Description</th>
                                    <th style="width: 160px;">Button</th>
                                    <th style="width: 90px;">Status</th>
                                    <th class="text-end pe-4" style="width: 110px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($hero_slides)): ?>
                                    <?php foreach ($hero_slides as $slide): 
                                        $slide_img_full = !empty($slide->image) ? (strpos($slide->image, 'http') === 0 ? $slide->image : $root_url . ltrim($slide->image, '/')) : ($root_url . 'assets/template2/images/resources/main-slider-img-1-1.png');
                                    ?>
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-secondary font-monospace">#<?= (int)$slide->sort_order ?></span>
                                            </td>
                                            <td>
                                                <div class="rounded p-1 bg-black bg-opacity-25 border border-secondary text-center" style="width: 70px; height: 55px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                    <img src="<?= htmlspecialchars($slide_img_full) ?>" alt="Slide Image" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($slide->badge)): ?>
                                                    <span class="badge bg-warning text-dark fw-bold mb-1 d-inline-block small text-truncate" style="max-width: 250px;">
                                                        <?= htmlspecialchars($slide->badge) ?>
                                                    </span>
                                                <?php endif; ?>
                                                <div class="text-white fw-bold" style="max-width: 270px; line-height: 1.3;">
                                                    <?= nl2br(strip_tags($slide->title, '<br><br/><span><strong><em><b><i>')) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-light small" style="max-width: 320px; line-height: 1.4;">
                                                    <?= htmlspecialchars($slide->description) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-white small fw-semibold"><i class="fa-solid fa-link me-1 text-warning"></i><?= htmlspecialchars($slide->button_text ?: 'Book Appointment') ?></div>
                                                <div class="text-muted font-monospace small"><?= htmlspecialchars($slide->button_url ?: 'booking') ?></div>
                                            </td>
                                            <td>
                                                <span class="badge <?= $slide->status === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= ucfirst($slide->status) ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <script type="application/json" id="heroSlideData_<?= (int)$slide->id ?>"><?= json_encode($slide, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?></script>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-light btn-edit-hero-slide" data-id="<?= (int)$slide->id ?>" data-bs-toggle="modal" data-bs-target="#modalHeroSlide" onclick="triggerEditHeroSlide(<?= (int)$slide->id ?>)" title="Edit Slide">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" onclick="deleteHeroSlide(<?= (int)$slide->id ?>)" title="Delete Slide">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-bullhorn fa-2x mb-2 text-secondary d-block"></i>
                                            No hero slides found for this layout. Click <strong>"+ Add New Hero Slide"</strong> to add slides to the banner.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-black bg-opacity-25 py-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        Total slides configured: <strong><?= count($hero_slides) ?></strong>
                    </span>
                    <button type="button" class="btn btn-warning btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalHeroSlide" onclick="openNewHeroSlideModal()">
                        <i class="fa-solid fa-plus me-1"></i> Add Another Slide
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <!-- ============================================== -->
        <!-- 2. FEATURES / OUR WORKS SECTION                -->
        <!-- ============================================== -->
        <?php if ($curr_sec === 'skincare'): 
            $feat_section_name = $curr_layout === 2 ? 'Our Works' : ($curr_layout === 1 ? 'Featured Skincare' : 'Features');
            $feat_def_tagline = $curr_layout === 2 ? 'Our Works' : ($curr_layout === 1 ? 'Featured Skincare' : 'Special Highlights');
            $feat_def_title = $curr_layout === 2 ? 'Glow Transformation Gallery' : ($curr_layout === 1 ? 'Beauty and Glow Skin Solutions' : 'Exclusive Treatments & Skincare Highlights');
            $feat_tagline = get_tpl_setting($curr_target_tpl, $curr_layout, 'featured_skincare', 'tagline', $feat_def_tagline);
            $feat_title = get_tpl_setting($curr_target_tpl, $curr_layout, 'featured_skincare', 'title', $feat_def_title);
        ?>
            <!-- Header Settings Card -->
            <form action="<?= superadmin_url('layouts') ?>" method="post" class="mb-4">
                <input type="hidden" name="action" value="save_featured_skincare_headers">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="skincare">

                <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(255,255,255,0.08) !important;">
                    <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-sparkles text-warning me-2"></i><?= htmlspecialchars($feat_section_name) ?> Section Heading (Layout <?= $curr_layout ?>)
                        </h5>
                        <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">
                            <i class="fa-solid fa-check me-1"></i> Save Headers
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-white small fw-bold">Section Tagline</label>
                                <input type="text" name="featured_tagline" class="form-control" value="<?= htmlspecialchars($feat_tagline) ?>" placeholder="<?= htmlspecialchars($feat_def_tagline) ?>">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label text-white small fw-bold">Section Title Heading</label>
                                <input type="text" name="featured_title" class="form-control" value="<?= htmlspecialchars($feat_title) ?>" placeholder="<?= htmlspecialchars($feat_def_title) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Items Management Card -->
            <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.25) !important;">
                <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-table-cells text-warning me-2"></i><?= htmlspecialchars($feat_section_name) ?> Items (Layout <?= $curr_layout ?>)
                        </h5>
                        <p class="text-muted small mb-0">Each card contains thumbnail, title, and short description.</p>
                    </div>
                    <button type="button" class="btn btn-gold btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalFeaturedItem" onclick="openNewFeaturedModal()">
                        <i class="fa-solid fa-plus me-1"></i> Add Item
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <?php if (!empty($featured_items)): ?>
                            <?php foreach ($featured_items as $item): 
                                $thumb_src = strpos($item->thumbnail, 'http') === 0 ? $item->thumbnail : $root_url . ltrim($item->thumbnail, '/');
                            ?>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card h-100 border-0 rounded-3 overflow-hidden shadow-sm" style="background: #080d19; border: 1px solid rgba(255,255,255,0.08) !important;">
                                        <div class="position-relative" style="height: 160px; overflow: hidden;">
                                            <img src="<?= htmlspecialchars($thumb_src) ?>" alt="<?= htmlspecialchars($item->title) ?>" class="w-100 h-100" style="object-fit: cover;">
                                            <span class="position-absolute top-0 end-0 m-2 badge <?= $item->status === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= ucfirst($item->status) ?>
                                            </span>
                                        </div>
                                        <div class="card-body p-3 d-flex flex-column">
                                            <h6 class="text-white fw-bold mb-1"><?= htmlspecialchars($item->title) ?></h6>
                                            <p class="text-light text-opacity-75 small mb-3 flex-grow-1"><?= htmlspecialchars($item->short_desc) ?></p>
                                            <div class="d-flex align-items-center justify-content-between pt-2 border-top border-secondary border-opacity-25">
                                                <button type="button" class="btn btn-outline-light btn-sm fw-semibold" onclick="openEditFeaturedModal(<?= htmlspecialchars(json_encode($item)) ?>)">
                                                    <i class="fa-solid fa-pencil me-1"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteFeaturedItem(<?= (int)$item->id ?>)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-4 text-muted">
                                <i class="fa-solid fa-inbox fa-3x mb-2"></i>
                                <p>No featured items found. Click "+ Add Featured Item" to create one.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ============================================== -->
        <!-- 3. ABOUT US SECTION                            -->
        <!-- ============================================== -->
        <?php if ($curr_sec === 'about'): 
            $about_tagline = get_tpl_setting($curr_target_tpl, $curr_layout, 'about', 'about_tagline', 'About Us');
            $about_title = get_tpl_setting($curr_target_tpl, $curr_layout, 'about', 'about_title', 'Explore Our Dedication to Beauty and Care');
            $about_desc = get_tpl_setting($curr_target_tpl, $curr_layout, 'about', 'about_desc', 'We are passionate about helping you achieve your best look and relaxation.');
            $about_exp = get_tpl_setting($curr_target_tpl, $curr_layout, 'about', 'about_experience', '25');
            $about_author = get_tpl_setting($curr_target_tpl, $curr_layout, 'about', 'about_author_name', 'Emma Watson');
            $about_role = get_tpl_setting($curr_target_tpl, $curr_layout, 'about', 'about_author_role', 'Founder & Master Stylist');
            $about_img1 = get_tpl_setting($curr_target_tpl, $curr_layout, 'about', 'about_image_1', ($curr_target_tpl === 'template1' ? 'assets/template1/images/demo-1/about-img.jpg' : 'assets/template2/images/resources/about-one-img-1.jpg'));
            $about_img2 = get_tpl_setting($curr_target_tpl, $curr_layout, 'about', 'about_image_2', ($curr_target_tpl === 'template1' ? 'assets/template1/images/demo-2/about-img-2.jpg' : 'assets/template2/images/resources/about-one-img-2.jpg'));
            $img1_full = strpos($about_img1, 'http') === 0 ? $about_img1 : $root_url . ltrim($about_img1, '/');
            $img2_full = strpos($about_img2, 'http') === 0 ? $about_img2 : $root_url . ltrim($about_img2, '/');
        ?>
            <form action="<?= superadmin_url('layouts') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_about_us">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="about">

                <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(255,255,255,0.08) !important;">
                    <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-address-card text-warning me-2"></i>About Us Section &bull; <?= htmlspecialchars($layout_names[$curr_layout]) ?>
                        </h5>
                        <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">
                            <i class="fa-solid fa-check me-1"></i> Save About Us
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label text-white small fw-bold">Section Tagline</label>
                                        <input type="text" name="about_tagline" class="form-control" value="<?= htmlspecialchars($about_tagline) ?>" placeholder="About Us">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label text-white small fw-bold">Section Title Heading</label>
                                        <input type="text" name="about_title" class="form-control" value="<?= htmlspecialchars($about_title) ?>" placeholder="Explore Our Dedication to Healthy Skin">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-white small fw-bold">Story &amp; Description</label>
                                    <textarea name="about_desc" class="form-control" rows="4"><?= htmlspecialchars($about_desc) ?></textarea>
                                </div>
                                <div class="row g-3">
                                    <div class="<?= ($curr_layout === 2) ? 'col-md-4' : 'col-md-6' ?>">
                                        <label class="form-label text-white small fw-bold">Years of Experience</label>
                                        <input type="text" name="about_experience" class="form-control" value="<?= htmlspecialchars($about_exp) ?>" placeholder="27">
                                    </div>
                                    <?php if ($curr_layout === 2): ?>
                                    <div class="col-md-4">
                                        <label class="form-label text-white small fw-bold">Author / Founder Name</label>
                                        <input type="text" name="about_author_name" class="form-control" value="<?= htmlspecialchars($about_author) ?>" placeholder="Emma Watson">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label text-white small fw-bold">Author Role / Designation</label>
                                        <input type="text" name="about_author_role" class="form-control" value="<?= htmlspecialchars($about_role) ?>" placeholder="Founder CEO">
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label text-white small fw-bold">About Section Images</label>
                                <!-- Image 1 -->
                                <div class="p-3 rounded-3 mb-3" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.08);">
                                    <div class="small text-muted fw-bold mb-1">Primary Image:</div>
                                    <img src="<?= htmlspecialchars($img1_full) ?>" alt="About Img 1" class="img-fluid rounded mb-2" style="max-height: 100px; object-fit: cover;">
                                    <input type="file" name="about_image_1_file" class="form-control form-control-sm mb-1" accept="image/*">
                                    <input type="text" name="about_image_1_url" class="form-control form-control-sm" value="<?= htmlspecialchars($about_img1) ?>" placeholder="image path">
                                </div>
                                <!-- Image 2 -->
                                <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.08);">
                                    <div class="small text-muted fw-bold mb-1">Secondary / Experience Image:</div>
                                    <img src="<?= htmlspecialchars($img2_full) ?>" alt="About Img 2" class="img-fluid rounded mb-2" style="max-height: 100px; object-fit: cover;">
                                    <input type="file" name="about_image_2_file" class="form-control form-control-sm mb-1" accept="image/*">
                                    <input type="text" name="about_image_2_url" class="form-control form-control-sm" value="<?= htmlspecialchars($about_img2) ?>" placeholder="image path">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-black bg-opacity-25 py-3 border-top border-secondary border-opacity-25 text-end">
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="fa-solid fa-check me-1"></i> Save About Us
                        </button>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <!-- ============================================== -->
        <!-- 4. WE OFFER (SERVICES) SECTION                 -->
        <!-- ============================================== -->
        <?php if ($curr_sec === 'services'): 
            $svc_tagline = get_tpl_setting($curr_target_tpl, $curr_layout, 'services_header', 'tagline', 'We Offer');
            $svc_title = get_tpl_setting($curr_target_tpl, $curr_layout, 'services_header', 'title', 'Beauty and Salon Services');
            $svc_desc = get_tpl_setting($curr_target_tpl, $curr_layout, 'services_header', 'desc', 'Our salon and spa services are designed to nourish, protect, and enhance your natural beauty.');
        ?>
            <!-- Header Settings Card -->
            <form action="<?= superadmin_url('layouts') ?>" method="post" class="mb-4">
                <input type="hidden" name="action" value="save_services_headers">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="services">

                <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(255,255,255,0.08) !important;">
                    <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-hand-holding-heart text-warning me-2"></i>Services Section Heading &amp; Copy
                        </h5>
                        <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">
                            <i class="fa-solid fa-check me-1"></i> Save Headers
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-white small fw-bold">Section Tagline</label>
                                <input type="text" name="services_tagline" class="form-control" value="<?= htmlspecialchars($svc_tagline) ?>" placeholder="We Offer">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label text-white small fw-bold">Section Title Heading</label>
                                <input type="text" name="services_title" class="form-control" value="<?= htmlspecialchars($svc_title) ?>" placeholder="Beauty and Salon Services">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-white small fw-bold">Section Lead Description</label>
                                <textarea name="services_desc" class="form-control" rows="2"><?= htmlspecialchars($svc_desc) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Services Management List -->
            <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.25) !important;">
                <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-spa text-warning me-2"></i>Services Catalogue &amp; Detail Pages
                        </h5>
                        <p class="text-muted small mb-0">Each service includes thumbnail, title, short description, and rich text editor description linking to dedicated detail page (no search bar).</p>
                    </div>
                    <button type="button" class="btn btn-gold btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalService" onclick="openNewServiceModal()">
                        <i class="fa-solid fa-plus me-1"></i> Add New Service
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0" style="background: transparent;">
                            <thead>
                                <tr class="text-white-50 small border-secondary">
                                    <th style="width: 70px;">Thumb</th>
                                    <th>Service Name &amp; Slug</th>
                                    <th>Short Description</th>
                                    <th>Price &amp; Duration</th>
                                    <th>Status</th>
                                    <th>Detail Page</th>
                                    <th class="text-end" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($services_list)): ?>
                                    <?php foreach ($services_list as $svc): 
                                        $svc_thumb = strpos($svc->thumbnail, 'http') === 0 ? $svc->thumbnail : $root_url . ltrim($svc->thumbnail, '/');
                                        $detail_url = tenant_site_url('service/' . $svc->slug . '?preview_tpl=' . $curr_target_tpl . '&preview_layout=' . $curr_layout);
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="<?= htmlspecialchars($svc_thumb) ?>" alt="<?= htmlspecialchars($svc->title) ?>" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <div class="text-white fw-bold"><?= htmlspecialchars($svc->title) ?></div>
                                                <div class="text-muted font-monospace small">/service/<?= htmlspecialchars($svc->slug) ?></div>
                                            </td>
                                            <td>
                                                <div class="text-light small text-truncate" style="max-width: 280px;">
                                                    <?= htmlspecialchars($svc->short_desc) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark fw-bold">$<?= number_format($svc->price, 2) ?></span>
                                                <span class="badge bg-dark border border-secondary text-light"><?= htmlspecialchars($svc->duration) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge <?= $svc->status === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= ucfirst($svc->status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= $detail_url ?>" target="_blank" class="btn btn-outline-info btn-sm">
                                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Detail Page
                                                </a>
                                            </td>
                                            <td class="text-end">
                                                <script type="application/json" id="svcData_<?= (int)$svc->id ?>"><?= json_encode($svc, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?></script>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-light btn-edit-service" data-id="<?= (int)$svc->id ?>" data-bs-toggle="modal" data-bs-target="#modalService" onclick="triggerEditService(<?= (int)$svc->id ?>)" title="Edit Service">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" onclick="deleteService(<?= (int)$svc->id ?>)" title="Delete Service">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            No services found. Click "+ Add New Service" to create one.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ============================================== -->
        <!-- 5. TESTIMONIALS SECTION                        -->
        <!-- ============================================== -->
        <?php if ($curr_sec === 'testimonials'): 
            $testi_tagline = get_tpl_setting($curr_target_tpl, $curr_layout, 'testimonials_header', 'tagline', 'Testimonial');
            $testi_title = get_tpl_setting($curr_target_tpl, $curr_layout, 'testimonials_header', 'title', 'Radiant Reviews from Our Happy Clients');
        ?>
            <!-- Header Settings Card -->
            <form action="<?= superadmin_url('layouts') ?>" method="post" class="mb-4">
                <input type="hidden" name="action" value="save_testimonials_headers">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="testimonials">

                <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(255,255,255,0.08) !important;">
                    <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-comments text-warning me-2"></i>Testimonials Section Heading
                        </h5>
                        <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">
                            <i class="fa-solid fa-check me-1"></i> Save Headers
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-white small fw-bold">Section Tagline</label>
                                <input type="text" name="testimonials_tagline" class="form-control" value="<?= htmlspecialchars($testi_tagline) ?>" placeholder="Testimonial">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label text-white small fw-bold">Section Title Heading</label>
                                <input type="text" name="testimonials_title" class="form-control" value="<?= htmlspecialchars($testi_title) ?>" placeholder="Radiant Reviews from Our Happy Clients">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Testimonials Management List -->
            <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.25) !important;">
                <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-quote-left text-warning me-2"></i>Client Testimonials
                        </h5>
                        <p class="text-muted small mb-0">Manage customer review quotes, star ratings, and avatars.</p>
                    </div>
                    <button type="button" class="btn btn-gold btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalTestimonial" onclick="openNewTestimonialModal()">
                        <i class="fa-solid fa-plus me-1"></i> Add Testimonial
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <?php if (!empty($testimonials_list)): ?>
                            <?php foreach ($testimonials_list as $tst): 
                                $tst_avatar = strpos($tst->avatar, 'http') === 0 ? $tst->avatar : $root_url . ltrim($tst->avatar, '/');
                            ?>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 rounded-3 p-3 shadow-sm" style="background: #080d19; border: 1px solid rgba(255,255,255,0.08) !important;">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="<?= htmlspecialchars($tst_avatar) ?>" alt="<?= htmlspecialchars($tst->client_name) ?>" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                                                <div>
                                                    <div class="text-white fw-bold"><?= htmlspecialchars($tst->client_name) ?></div>
                                                    <div class="text-muted small"><?= htmlspecialchars($tst->designation) ?></div>
                                                </div>
                                            </div>
                                            <div class="text-warning small">
                                                <?php for ($i = 0; $i < (int)$tst->rating; $i++): ?>
                                                    <i class="fa-solid fa-star"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <p class="text-light text-opacity-75 small fst-italic mb-3 flex-grow-1">
                                            "<?= htmlspecialchars($tst->review) ?>"
                                        </p>
                                        <div class="d-flex align-items-center justify-content-between pt-2 border-top border-secondary border-opacity-25">
                                            <span class="badge <?= $tst->status === 'active' ? 'bg-success' : 'bg-secondary' ?> small">
                                                <?= ucfirst($tst->status) ?>
                                            </span>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-light" onclick="openEditTestimonialModal(<?= htmlspecialchars(json_encode($tst)) ?>)">
                                                    <i class="fa-solid fa-pencil me-1"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-outline-danger" onclick="deleteTestimonial(<?= (int)$tst->id ?>)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-4 text-muted">
                                No testimonials found. Click "+ Add Testimonial" to create one.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ============================================== -->
        <!-- 6. FAQS SECTION (LAYOUT 1)                     -->
        <!-- ============================================== -->
        <?php if ($curr_sec === 'faqs'): 
            $faq_tagline = get_tpl_setting($curr_target_tpl, $curr_layout, 'faq_header', 'tagline', 'Frequently Asked Questions');
            $faq_title = get_tpl_setting($curr_target_tpl, $curr_layout, 'faq_header', 'title', 'Clear Answers About Your Treatment');
        ?>
            <!-- Header Settings Card -->
            <form action="<?= superadmin_url('layouts') ?>" method="post" class="mb-4">
                <input type="hidden" name="action" value="save_faqs_headers">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="faqs">

                <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(255,255,255,0.08) !important;">
                    <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-circle-question text-warning me-2"></i>FAQ Section Heading (Layout <?= $curr_layout ?>)
                        </h5>
                        <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">
                            <i class="fa-solid fa-check me-1"></i> Save Headers
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-white small fw-bold">Section Tagline</label>
                                <input type="text" name="faq_tagline" class="form-control" value="<?= htmlspecialchars($faq_tagline) ?>" placeholder="Frequently Asked Questions">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label text-white small fw-bold">Section Title Heading</label>
                                <input type="text" name="faq_title" class="form-control" value="<?= htmlspecialchars($faq_title) ?>" placeholder="Clear Answers About Your Treatment">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- FAQ Items Management List -->
            <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.25) !important;">
                <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-list-check text-warning me-2"></i>Frequently Asked Questions (Layout <?= $curr_layout ?>)
                        </h5>
                        <p class="text-muted small mb-0">Manage accordion Q&amp;A pairs displayed on Layout <?= $curr_layout ?>.</p>
                    </div>
                    <button type="button" class="btn btn-gold btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalFaq" onclick="openNewFaqModal()">
                        <i class="fa-solid fa-plus me-1"></i> Add FAQ
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="accordion" id="accordionFaqsAdmin">
                        <?php if (!empty($faqs_list)): ?>
                            <?php foreach ($faqs_list as $idx => $fq): ?>
                                <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden" style="background: #080d19; border: 1px solid rgba(255,255,255,0.08) !important;">
                                    <h2 class="accordion-header" id="headingFaq<?= $fq->id ?>">
                                        <button class="accordion-button <?= $idx === 0 ? '' : 'collapsed' ?> text-white fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq<?= $fq->id ?>" style="background: rgba(255,255,255,0.03);">
                                            <span class="badge bg-warning text-dark me-2 font-monospace">Q<?= $idx + 1 ?></span>
                                            <?= htmlspecialchars($fq->question) ?>
                                        </button>
                                    </h2>
                                    <div id="collapseFaq<?= $fq->id ?>" class="accordion-collapse collapse <?= $idx === 0 ? 'show' : '' ?>" data-bs-parent="#accordionFaqsAdmin">
                                        <div class="accordion-body text-light text-opacity-75 small">
                                            <p class="mb-3"><?= nl2br(htmlspecialchars($fq->answer)) ?></p>
                                            <div class="d-flex align-items-center justify-content-between pt-2 border-top border-secondary border-opacity-25">
                                                <span class="badge <?= $fq->status === 'active' ? 'bg-success' : 'bg-secondary' ?> small">
                                                    <?= ucfirst($fq->status) ?>
                                                </span>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-light" onclick="openEditFaqModal(<?= htmlspecialchars(json_encode($fq)) ?>)">
                                                        <i class="fa-solid fa-pencil me-1"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" onclick="deleteFaq(<?= (int)$fq->id ?>)">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                No FAQs found. Click "+ Add FAQ" to create one.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ============================================== -->
        <!-- 7. LATEST NEWS (BLOG) SECTION                  -->
        <!-- ============================================== -->
        <?php if ($curr_sec === 'blogs'): 
            $blog_tagline = get_tpl_setting($curr_target_tpl, $curr_layout, 'blog_header', 'tagline', 'Latest News');
            $blog_title = get_tpl_setting($curr_target_tpl, $curr_layout, 'blog_header', 'title', 'Latest News & Articles From Our Experts');
            $blog_desc = get_tpl_setting($curr_target_tpl, $curr_layout, 'blog_header', 'desc', 'Beautiful skin doesn\'t happen overnight. It requires patience and consistency.');
        ?>
            <!-- Header Settings Card -->
            <form action="<?= superadmin_url('layouts') ?>" method="post" class="mb-4">
                <input type="hidden" name="action" value="save_blogs_headers">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="blogs">

                <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(255,255,255,0.08) !important;">
                    <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-newspaper text-warning me-2"></i>Blog Section Heading &amp; Copy
                        </h5>
                        <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">
                            <i class="fa-solid fa-check me-1"></i> Save Headers
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-white small fw-bold">Section Tagline</label>
                                <input type="text" name="blog_tagline" class="form-control" value="<?= htmlspecialchars($blog_tagline) ?>" placeholder="Latest News">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label text-white small fw-bold">Section Title Heading</label>
                                <input type="text" name="blog_title" class="form-control" value="<?= htmlspecialchars($blog_title) ?>" placeholder="Latest News & Articles">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-white small fw-bold">Section Lead Description</label>
                                <textarea name="blog_desc" class="form-control" rows="2"><?= htmlspecialchars($blog_desc) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Blogs Management List -->
            <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.25) !important;">
                <div class="card-header bg-black bg-opacity-25 py-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fa-solid fa-pen-nib text-warning me-2"></i>Layout <?= $curr_layout ?> Published Articles &amp; Blog Detail Pages
                            <span class="badge bg-warning text-dark ms-2 font-monospace">Layout <?= $curr_layout ?></span>
                        </h5>
                        <p class="text-muted small mb-0">Each blog post has thumbnail, author, date, excerpt, and full rich text description linking to dedicated detail page (no search bar).</p>
                    </div>
                    <button type="button" class="btn btn-gold btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalBlog" onclick="openNewBlogModal()">
                        <i class="fa-solid fa-plus me-1"></i> Add New Blog Post
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0" style="background: transparent;">
                            <thead>
                                <tr class="text-white-50 small border-secondary">
                                    <th style="width: 70px;">Thumb</th>
                                    <th>Article Title &amp; Slug</th>
                                    <th>Author &amp; Date</th>
                                    <th>Excerpt</th>
                                    <th>Status</th>
                                    <th>Detail Page</th>
                                    <th class="text-end" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($blogs_list)): ?>
                                    <?php foreach ($blogs_list as $blg): 
                                        $blg_thumb = strpos($blg->thumbnail, 'http') === 0 ? $blg->thumbnail : $root_url . ltrim($blg->thumbnail, '/');
                                        $detail_url = tenant_site_url('blog/' . $blg->slug . '?preview_tpl=' . $curr_target_tpl . '&preview_layout=' . $curr_layout);
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="<?= htmlspecialchars($blg_thumb) ?>" alt="<?= htmlspecialchars($blg->title) ?>" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <div class="text-white fw-bold"><?= htmlspecialchars($blg->title) ?></div>
                                                <div class="text-muted font-monospace small">/blog/<?= htmlspecialchars($blg->slug) ?></div>
                                            </td>
                                            <td>
                                                <div class="text-light small"><i class="fa-solid fa-user me-1 text-warning"></i><?= htmlspecialchars($blg->author_name) ?></div>
                                                <div class="text-muted small"><i class="fa-solid fa-calendar me-1"></i><?= htmlspecialchars($blg->published_date) ?></div>
                                            </td>
                                            <td>
                                                <div class="text-light small text-truncate" style="max-width: 250px;">
                                                    <?= htmlspecialchars($blg->short_desc) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge <?= $blg->status === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= ucfirst($blg->status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= $detail_url ?>" target="_blank" class="btn btn-outline-info btn-sm">
                                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Detail Page
                                                </a>
                                            </td>
                                            <td class="text-end">
                                                <script type="application/json" id="blogData_<?= (int)$blg->id ?>"><?= json_encode($blg, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?></script>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-light btn-edit-blog" data-id="<?= (int)$blg->id ?>" data-bs-toggle="modal" data-bs-target="#modalBlog" onclick="triggerEditBlog(<?= (int)$blg->id ?>)" title="Edit Article">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" onclick="deleteBlog(<?= (int)$blg->id ?>)" title="Delete Article">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            No blog posts found. Click "+ Add New Blog Post" to publish one.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php endif; /* End Tab 2: Template 2 Customizer */ ?>

</div><!-- /container-fluid -->


<!-- ======================================================== -->
<!-- MODALS                                                   -->
<!-- ======================================================== -->

<!-- MODAL: ADD / EDIT HERO BANNER SLIDE -->
<div class="modal fade" id="modalHeroSlide" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <form action="<?= superadmin_url('layouts') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_hero_slide">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="hero">
                <input type="hidden" name="slide_id" id="heroSlideId" value="0">
                <input type="hidden" name="layout_number" id="heroSlideLayoutNum" value="<?= $curr_layout ?>">

                <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title text-white fw-bold" id="heroSlideModalTitle">Add Hero Banner Slide</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Tagline / Subtitle Badge</label>
                            <input type="text" name="badge" id="heroSlideBadge" class="form-control" placeholder="e.g. True Beauty Starts with Healthy Skin">
                        </div>
                        <div class="col-12" style="max-width: 800px;">
                            <label class="form-label text-white small fw-bold">Main Banner Title (HTML allowed for breaks)</label>
                            <input type="text" name="title" id="heroSlideTitle" class="form-control font-monospace" style="max-width: 800px;" required placeholder="e.g. Glow Starts with <br> Healthy Skin">
                            <div class="form-text text-muted small">Use <code>&lt;br&gt;</code> to create clean multi-line headline breaks.</div>
                        </div>
                        <div class="col-12" style="max-width: 800px;">
                            <label class="form-label text-white small fw-bold">Hero Description / Lead Copy</label>
                            <textarea name="description" id="heroSlideDesc" class="form-control" style="max-width: 800px;" rows="3" placeholder="Healthy skin is the true foundation of lasting beauty..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Primary Button Text</label>
                            <input type="text" name="button_text" id="heroSlideBtnText" class="form-control" value="Book Appointment" placeholder="Book Appointment">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Primary Button Link / Action</label>
                            <input type="text" name="button_url" id="heroSlideBtnUrl" class="form-control" value="booking" placeholder="booking">
                        </div>
                        
                        <!-- Slide Visual Image -->
                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Slide Visual / Model Image</label>
                            <input type="file" name="image_file" class="form-control form-control-sm mb-1" accept="image/*">
                            <input type="text" name="image_url" id="heroSlideImageUrl" class="form-control form-control-sm" placeholder="assets/template2/images/resources/main-slider-img-1-1.png">
                            <div class="small text-muted mt-1">Relative path or upload image file.</div>
                        </div>

                        <!-- Slide Background Image (optional) -->
                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Slide Background Image (Optional)</label>
                            <input type="file" name="background_image_file" class="form-control form-control-sm mb-1" accept="image/*">
                            <input type="text" name="background_image_url" id="heroSlideBgUrl" class="form-control form-control-sm" placeholder="assets/template2/images/backgrounds/slider-1-1.jpg">
                            <div class="small text-muted mt-1">Leave empty to use layout default background.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="heroSlideSortOrder" class="form-control" value="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Status</label>
                            <select name="status" id="heroSlideStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="heroSlideSubmitBtn" class="btn btn-warning btn-sm fw-bold px-4">Save Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: ADD / EDIT FEATURED SKINCARE ITEM (LAYOUT 1) -->
<div class="modal fade" id="modalFeaturedItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <form action="<?= superadmin_url('layouts') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_featured_item">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="skincare">
                <input type="hidden" name="item_id" id="featItemId" value="0">
                <input type="hidden" name="layout_number" id="featLayoutNum" value="<?= $curr_layout ?>">

                <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title text-white fw-bold" id="featModalTitle">Add Featured Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Title</label>
                        <input type="text" name="title" id="featTitle" class="form-control" required placeholder="e.g. Deep Hydration Therapy">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Short Description</label>
                        <textarea name="short_desc" id="featShortDesc" class="form-control" rows="3" placeholder="Brief description of the service"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Thumbnail Image</label>
                        <input type="file" name="thumbnail_file" class="form-control mb-1" accept="image/*">
                        <input type="text" name="thumbnail_url" id="featThumbnailUrl" class="form-control form-control-sm" placeholder="Or relative path / URL">
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="featSortOrder" class="form-control" value="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Status</label>
                            <select name="status" id="featStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: ADD / EDIT SERVICE (WITH WYSIWYG EDITOR) -->
<div class="modal fade" id="modalService" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <form action="<?= superadmin_url('layouts') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_service">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="services">
                <input type="hidden" name="service_id" id="svcId" value="0">
                <input type="hidden" name="layout_number" id="svcLayoutNum" value="<?= $curr_layout ?>">

                <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title text-white fw-bold" id="svcModalTitle">Add New Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-white small fw-bold">Service Title *</label>
                            <input type="text" name="title" id="svcTitle" class="form-control" required placeholder="e.g. Deep Cleansing Facial">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">URL Slug (autogenerated if blank)</label>
                            <input type="text" name="slug" id="svcSlug" class="form-control font-monospace" placeholder="e.g. cleansing-facial">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Thumbnail (Card)</label>
                            <input type="file" name="thumbnail_file" class="form-control form-control-sm mb-1" accept="image/*">
                            <input type="text" name="thumbnail_url" id="svcThumbUrl" class="form-control form-control-sm" placeholder="assets/template2/images/services/services-1-1.jpg">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Banner / Detail Hero Image</label>
                            <input type="file" name="banner_image_file" class="form-control form-control-sm mb-1" accept="image/*">
                            <input type="text" name="banner_image_url" id="svcBannerUrl" class="form-control form-control-sm" placeholder="assets/template2/images/services/service-details-img4.jpg">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-white small fw-bold">Price ($)</label>
                            <input type="number" step="0.01" name="price" id="svcPrice" class="form-control" value="85.00">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-white small fw-bold">Duration</label>
                            <input type="text" name="duration" id="svcDuration" class="form-control" value="60 mins">
                        </div>

                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Short Description (Card Excerpt) *</label>
                            <textarea name="short_desc" id="svcShortDesc" class="form-control" rows="2" placeholder="Brief 1-2 sentence overview"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Full Detailed Description (WYSIWYG Rich Text Editor) *</label>
                            <textarea name="description" id="svcDescriptionEditor" class="summernote-editor form-control" rows="8"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="svcSortOrder" class="form-control" value="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Status</label>
                            <select name="status" id="svcStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-4">Save Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: ADD / EDIT TESTIMONIAL -->
<div class="modal fade" id="modalTestimonial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <form action="<?= superadmin_url('layouts') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_testimonial">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="testimonials">
                <input type="hidden" name="testimonial_id" id="testiId" value="0">
                <input type="hidden" name="layout_number" value="0">

                <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title text-white fw-bold" id="testiModalTitle">Add Testimonial</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label text-white small fw-bold">Client Name *</label>
                            <input type="text" name="client_name" id="testiName" class="form-control" required placeholder="Sarah Jenkins">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label text-white small fw-bold">Rating (Stars)</label>
                            <select name="rating" id="testiRating" class="form-select">
                                <option value="5">5 Stars (Excellent)</option>
                                <option value="4">4 Stars (Very Good)</option>
                                <option value="3">3 Stars (Average)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Designation / Role</label>
                            <input type="text" name="designation" id="testiDesignation" class="form-control" placeholder="Fashion Stylist / Loyal Guest">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Review Quote *</label>
                            <textarea name="review" id="testiReview" class="form-control" rows="3" required placeholder="Their review experience..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Client Avatar / Photo</label>
                            <input type="file" name="avatar_file" class="form-control form-control-sm mb-1" accept="image/*">
                            <input type="text" name="avatar_url" id="testiAvatarUrl" class="form-control form-control-sm" placeholder="assets/template2/images/testimonial/testimonial-v1-img1.jpg">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="testiSortOrder" class="form-control" value="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Status</label>
                            <select name="status" id="testiStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">Save Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: ADD / EDIT FAQ (LAYOUT 1) -->
<div class="modal fade" id="modalFaq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <form action="<?= superadmin_url('layouts') ?>" method="post">
                <input type="hidden" name="action" value="save_faq">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="faqs">
                <input type="hidden" name="faq_id" id="faqId" value="0">
                <input type="hidden" name="layout_number" id="faqLayoutNum" value="<?= $curr_layout ?>">

                <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title text-white fw-bold" id="faqModalTitle">Add FAQ Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Question *</label>
                        <input type="text" name="question" id="faqQuestion" class="form-control" required placeholder="e.g. What skincare treatments do you offer?">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Answer *</label>
                        <textarea name="answer" id="faqAnswer" class="form-control" rows="4" required placeholder="Clear, friendly answer for clients..."></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="faqSortOrder" class="form-control" value="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Status</label>
                            <select name="status" id="faqStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: ADD / EDIT BLOG POST (WITH WYSIWYG EDITOR) -->
<div class="modal fade" id="modalBlog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <form action="<?= superadmin_url('layouts') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_blog">
                <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
                <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
                <input type="hidden" name="active_section" value="blogs">
                <input type="hidden" name="blog_id" id="blogId" value="0">

                <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title text-white fw-bold" id="blogModalTitle">Publish Blog Article</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-white small fw-bold">Article Title *</label>
                            <input type="text" name="title" id="blogTitle" class="form-control" required placeholder="e.g. Skincare Secrets for a Natural Glow">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">URL Slug (autogenerated if blank)</label>
                            <input type="text" name="slug" id="blogSlug" class="form-control font-monospace" placeholder="e.g. skincare-secrets-natural-glow">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Author Name</label>
                            <input type="text" name="author_name" id="blogAuthor" class="form-control" value="Admin">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Published Date</label>
                            <input type="date" name="published_date" id="blogDate" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Tags (comma separated)</label>
                            <input type="text" name="tags" id="blogTags" class="form-control" placeholder="Skincare, Beauty, Wellness">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Thumbnail Image</label>
                            <input type="file" name="thumbnail_file" class="form-control form-control-sm mb-1" accept="image/*">
                            <input type="text" name="thumbnail_url" id="blogThumbUrl" class="form-control form-control-sm" placeholder="assets/template2/images/blog/blog-v1-img1.jpg">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Short Excerpt *</label>
                            <textarea name="short_desc" id="blogShortDesc" class="form-control" rows="2" placeholder="Brief summary displayed on homepage cards"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white small fw-bold">Full Article Content (WYSIWYG Rich Text Editor) *</label>
                            <textarea name="content" id="blogContentEditor" class="summernote-editor form-control" rows="8"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Target Layout *</label>
                            <select name="layout_number" id="blogLayoutNumber" class="form-select">
                                <option value="1" <?= $curr_layout == 1 ? 'selected' : '' ?>><?= $curr_target_tpl === 'template1' ? 'Home 1' : 'Layout 1' ?></option>
                                <option value="2" <?= $curr_layout == 2 ? 'selected' : '' ?>><?= $curr_target_tpl === 'template1' ? 'Home 2' : 'Layout 2' ?></option>
                                <option value="3" <?= $curr_layout == 3 ? 'selected' : '' ?>><?= $curr_target_tpl === 'template1' ? 'Home 3' : 'Layout 3' ?></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="blogSortOrder" class="form-control" value="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small fw-bold">Status</label>
                            <select name="status" id="blogStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="blogSubmitBtn" class="btn btn-warning btn-sm fw-bold px-4">Publish Article</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: TABLE PROPERTIES & BORDER CONFIGURATION -->
<div class="modal fade" id="modalTableProperties" tabindex="-1" style="z-index: 1070;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.45) !important;">
            <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                <h5 class="modal-title text-white fw-bold">
                    <i class="fa-solid fa-table-cells text-warning me-2"></i>Table Properties &amp; Borders
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-white">
                <!-- Quick 1-Click Borderless Action -->
                <div class="p-3 rounded-3 mb-4 d-flex align-items-center justify-content-between" style="background: rgba(194, 153, 88, 0.1); border: 1px dashed rgba(194, 153, 88, 0.4);">
                    <div>
                        <div class="fw-bold text-warning mb-1"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Quick Border Removal</div>
                        <div class="small text-muted">Strip all borders from this table with one click</div>
                    </div>
                    <button type="button" class="btn btn-outline-warning btn-sm fw-bold px-3" onclick="removeTableBorderFromModal()">
                        <i class="fa-solid fa-border-none me-1"></i> Remove All Borders
                    </button>
                </div>

                <div class="row g-3">
                    <!-- Border Style -->
                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Border Style</label>
                        <select id="tpBorderStyle" class="form-select bg-dark text-white border-secondary">
                            <option value="none">No Border (Borderless)</option>
                            <option value="solid" selected>Solid Line</option>
                            <option value="dashed">Dashed Line</option>
                            <option value="dotted">Dotted Line</option>
                            <option value="double">Double Line</option>
                        </select>
                    </div>

                    <!-- Border Width -->
                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Border Width</label>
                        <select id="tpBorderWidth" class="form-select bg-dark text-white border-secondary">
                            <option value="0px">0px (No Border)</option>
                            <option value="1px" selected>1px (Thin)</option>
                            <option value="2px">2px (Medium)</option>
                            <option value="3px">3px (Thick)</option>
                        </select>
                    </div>

                    <!-- Border Color -->
                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Border Color</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="color" id="tpBorderColor" class="form-control form-control-color bg-dark border-secondary" value="#c29958" style="width: 44px; height: 38px;">
                            <select id="tpBorderColorPreset" class="form-select bg-dark text-white border-secondary form-select-sm" onchange="if(this.value) $('#tpBorderColor').val(this.value);">
                                <option value="">Custom Color</option>
                                <option value="#c29958">Gold (#c29958)</option>
                                <option value="#ffffff">White (#ffffff)</option>
                                <option value="#334155">Dark Slate (#334155)</option>
                                <option value="#cbd5e1">Light Slate (#cbd5e1)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table Width -->
                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Table Width</label>
                        <select id="tpTableWidth" class="form-select bg-dark text-white border-secondary">
                            <option value="100%" selected>100% (Full Width)</option>
                            <option value="75%">75% Width</option>
                            <option value="50%">50% Width</option>
                            <option value="auto">Auto (Fit to content)</option>
                        </select>
                    </div>

                    <!-- Cell Padding -->
                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Cell Padding / Spacing</label>
                        <select id="tpCellPadding" class="form-select bg-dark text-white border-secondary">
                            <option value="none">None (0px)</option>
                            <option value="compact">Compact (4px 8px)</option>
                            <option value="normal" selected>Normal (10px 14px)</option>
                            <option value="spacious">Spacious (16px 20px)</option>
                        </select>
                    </div>

                    <!-- Table Alignment -->
                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Table Alignment</label>
                        <select id="tpTableAlign" class="form-select bg-dark text-white border-secondary">
                            <option value="left" selected>Left Aligned</option>
                            <option value="center">Centered</option>
                            <option value="right">Right Aligned</option>
                        </select>
                    </div>

                    <!-- Additional Toggles -->
                    <div class="col-12 pt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="tpStripedRows">
                            <label class="form-check-label text-white-50 small" for="tpStripedRows">
                                Alternating striped rows (zebra striping)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeTableBorderFromModal()">
                    <i class="fa-solid fa-border-none me-1"></i> Remove All Borders
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning btn-sm fw-bold px-4" onclick="applyTableProperties()">
                        <i class="fa-solid fa-check me-1"></i> Apply Properties
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: ADD / EDIT TEMPLATE -->
<div class="modal fade" id="modalTemplate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <form action="<?= superadmin_url('layouts') ?>" method="post">
                <input type="hidden" name="action" value="save_template">
                <input type="hidden" name="active_tab" value="multi-theme">
                <input type="hidden" name="template_id" id="tplId" value="0">

                <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title text-white fw-bold" id="tplModalTitle">Add New Template</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Template Key (Folder / Identifier)</label>
                        <input type="text" name="template_key" id="tplKey" class="form-control font-monospace" placeholder="e.g. template3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Template Display Name</label>
                        <input type="text" name="name" id="tplName" class="form-control" placeholder="e.g. Template 3: Modern Aesthetic" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Badge Text</label>
                            <input type="text" name="badge" id="tplBadge" class="form-control" placeholder="e.g. ULTRA LUXURY">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Icon Class</label>
                            <input type="text" name="icon" id="tplIcon" class="form-control" placeholder="fa-solid fa-crown">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Short Description</label>
                        <textarea name="short_desc" id="tplShortDesc" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Feature Highlights (one per line)</label>
                        <textarea name="features" id="tplFeatures" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="tplSortOrder" class="form-control" value="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Status</label>
                            <select name="status" id="tplStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">Save Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: ADD / EDIT LAYOUT -->
<div class="modal fade" id="modalLayout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4" style="background: #111a2e; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <form action="<?= superadmin_url('layouts') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_layout">
                <input type="hidden" name="active_tab" value="multi-theme">
                <input type="hidden" name="layout_id" id="layoutId" value="0">
                <input type="hidden" name="template_id" id="layoutTemplateId" value="0">

                <div class="modal-header bg-black bg-opacity-25 border-bottom border-secondary border-opacity-25 py-3">
                    <h5 class="modal-title text-white fw-bold" id="layoutModalTitle">Add Homepage Layout</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="p-2 mb-3 rounded bg-dark border border-secondary small text-warning">
                        Template: <strong id="layoutParentName" class="text-white">Template 1</strong>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label text-white small fw-bold">Layout #</label>
                            <input type="number" name="layout_number" id="layoutNumber" class="form-control" value="1" min="1" max="9" required>
                        </div>
                        <div class="col-8">
                            <label class="form-label text-white small fw-bold">Layout Display Name</label>
                            <input type="text" name="layout_name" id="layoutName" class="form-control" placeholder="e.g. Layout 1: Luxury Salon" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Preview Screenshot Image</label>
                        <input type="file" name="layout_preview_file" class="form-control mb-1" accept="image/*">
                        <input type="text" name="preview_image_url" id="layoutPreviewImageUrl" class="form-control form-control-sm" placeholder="Or relative path / URL">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small fw-bold">Demo / Preview Target URL</label>
                        <input type="text" name="demo_url" id="layoutDemoUrl" class="form-control font-monospace" placeholder="website/?preview_tpl=template2&preview_layout=1">
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="layoutSortOrder" class="form-control" value="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white small fw-bold">Status</label>
                            <select name="status" id="layoutStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-black bg-opacity-25 border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-3">Save Layout</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: INTERACTIVE PREVIEW MODAL (DESKTOP, TABLET, MOBILE) -->
<div class="modal fade" id="modalPreviewLayout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-3">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden" style="background: #080d19; border: 1px solid rgba(194, 153, 88, 0.4) !important;">
            <!-- Header with Device Switcher -->
            <div class="modal-header bg-black bg-opacity-75 py-2 px-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark fw-bold font-monospace px-2 py-1">PREVIEW</span>
                    <h5 class="modal-title text-white fw-bold mb-0 font-serif" id="pvLayoutTitle">Layout Preview</h5>
                    <span class="badge bg-secondary font-monospace" id="pvLayoutSubtitle">template1</span>
                </div>

                <!-- Device Width Controls -->
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group btn-group-sm" id="pvDeviceGroup">
                        <button type="button" class="btn btn-dark active text-warning" onclick="setPreviewDevice('100%', this)" title="Desktop (100%)">
                            <i class="fa-solid fa-desktop me-1"></i> Desktop
                        </button>
                        <button type="button" class="btn btn-outline-secondary text-light" onclick="setPreviewDevice('768px', this)" title="Tablet (768px)">
                            <i class="fa-solid fa-tablet-screen-button me-1"></i> Tablet
                        </button>
                        <button type="button" class="btn btn-outline-secondary text-light" onclick="setPreviewDevice('375px', this)" title="Mobile (375px)">
                            <i class="fa-solid fa-mobile-screen me-1"></i> Mobile
                        </button>
                    </div>

                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-warning btn-sm active" id="pvModeLive" onclick="setPreviewMode('live')">
                            <i class="fa-solid fa-play me-1"></i> Live Site
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm" id="pvModeImage" onclick="setPreviewMode('image')">
                            <i class="fa-solid fa-image me-1"></i> Screenshot
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="#" id="pvLaunchExternal" target="_blank" class="btn btn-outline-light btn-sm fw-semibold">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Open Tab
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>

            <!-- Preview Body -->
            <div class="modal-body p-0 position-relative d-flex justify-content-center align-items-center" style="background: #020612; overflow: hidden;">
                <div id="pvFrameWrapper" style="width: 100%; height: 100%; transition: width 0.3s ease; position: relative;">
                    <div id="pvLoading" class="position-absolute top-50 start-50 translate-middle text-center" style="z-index: 5;">
                        <div class="spinner-border text-warning mb-2" role="status"></div>
                        <div class="text-white-50 small">Loading layout render...</div>
                    </div>
                    <iframe id="pvIframe" src="about:blank" class="w-100 h-100 border-0" onload="document.getElementById('pvLoading').style.display='none';"></iframe>
                </div>

                <div id="pvImageWrapper" class="w-100 h-100 text-center p-3" style="display: none; overflow-y: auto;">
                    <img id="pvImage" src="" alt="Layout screenshot" class="img-fluid rounded shadow-lg border border-secondary" style="max-width: 1100px;">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summernote Lite JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
const baseSuperUrl = "<?= rtrim(superadmin_url(), '/') . '/' ?>";
const mainSiteUrl = "<?= rtrim(main_site_url(), '/') . '/' ?>";

function resolveMainUrl(path) {
    if (!path) return '';
    if (path.indexOf('http://') === 0 || path.indexOf('https://') === 0) return path;
    return mainSiteUrl + path.replace(/^\/+/, '');
}

// Active Table Tracking & Properties
let activeTableNode = null;
let activeEditorContext = null;

$(document).on('click mousedown keyup', '.note-editable table, .note-editable td, .note-editable th', function() {
    activeTableNode = $(this).closest('table')[0];
});

function getTargetTable(context) {
    if (context) activeEditorContext = context;
    if (activeTableNode && $(activeTableNode).closest('.note-editable').length) {
        return $(activeTableNode);
    }
    var sel = window.getSelection();
    if (sel && sel.anchorNode) {
        var $t = $(sel.anchorNode).closest('table');
        if ($t.length && $t.closest('.note-editable').length) {
            activeTableNode = $t[0];
            return $t;
        }
    }
    var $activeEditor = $('.note-editor.note-frame.focus, #modalService .note-editor, #modalBlog .note-editor').first();
    var $tables = $activeEditor.find('.note-editable table');
    if ($tables.length >= 1) {
        activeTableNode = $tables.first()[0];
        return $tables.first();
    }
    return null;
}

function showTableToast(msg) {
    $('.table-feedback-toast').remove();
    var $toast = $('<div class="table-feedback-toast position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">' +
        '<div class="toast show align-items-center text-white bg-dark border border-warning shadow-lg rounded-3" role="alert">' +
        '<div class="d-flex"><div class="toast-body fw-semibold"><i class="fa-solid fa-check text-warning me-2"></i>' + msg + '</div>' +
        '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
        '</div></div></div>');
    $('body').append($toast);
    setTimeout(function() {
        $toast.fadeOut(400, function() { $(this).remove(); });
    }, 2800);
}

function stripAllTableBorders($table) {
    if (!$table || !$table.length) return;

    $table.removeClass('table-bordered')
          .addClass('table-borderless no-border')
          .attr('data-borderless', '1')
          .attr('border', '0');

    $table.css({
        'border': 'none',
        'border-top': 'none',
        'border-bottom': 'none',
        'border-left': 'none',
        'border-right': 'none',
        'border-collapse': 'collapse'
    });

    $table.find('thead, tbody, tfoot, tr').each(function() {
        $(this).removeClass('table-bordered');
        this.style.setProperty('border', 'none', 'important');
        this.style.setProperty('border-top', 'none', 'important');
        this.style.setProperty('border-bottom', 'none', 'important');
        this.style.setProperty('border-left', 'none', 'important');
        this.style.setProperty('border-right', 'none', 'important');
        this.style.setProperty('box-shadow', 'none', 'important');
    });

    $table.find('td, th').each(function() {
        $(this).addClass('no-border');
        this.style.setProperty('border', 'none', 'important');
        this.style.setProperty('border-top', 'none', 'important');
        this.style.setProperty('border-bottom', 'none', 'important');
        this.style.setProperty('border-left', 'none', 'important');
        this.style.setProperty('border-right', 'none', 'important');
        this.style.setProperty('box-shadow', 'none', 'important');
    });
}

function removeTableBorderFromModal() {
    var $table = getTargetTable(activeEditorContext);
    if ($table && $table.length) {
        stripAllTableBorders($table);

        if (activeEditorContext && activeEditorContext.invoke) {
            try { activeEditorContext.invoke('editor.afterCommand'); } catch(e) {}
        }
        $('.summernote-editor').trigger('summernote.change');
    }
    var modalEl = document.getElementById('modalTableProperties');
    var modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
    showTableToast('All table borders removed completely!');
}

function openTablePropertiesModal(context) {
    var $table = getTargetTable(context);
    if (!$table || !$table.length) {
        alert('Please click inside a table to edit its properties, or insert a table first.');
        return;
    }

    var isBorderless = $table.hasClass('table-borderless') || $table.hasClass('no-border') || $table.attr('data-borderless') === '1' || $table.css('border-style') === 'none' || ($table.attr('style') && $table.attr('style').indexOf('border: none') !== -1);
    
    if (isBorderless) {
        $('#tpBorderStyle').val('none');
        $('#tpBorderWidth').val('0px');
    } else {
        var style = $table.css('border-style') || 'solid';
        $('#tpBorderStyle').val(style !== 'none' ? style : 'solid');
        var width = $table.css('border-width') || '1px';
        $('#tpBorderWidth').val(width !== '0px' ? width : '1px');
    }

    var curWidth = $table[0].style.width || '100%';
    if (curWidth === '100%' || curWidth === '75%' || curWidth === '50%' || curWidth === 'auto') {
        $('#tpTableWidth').val(curWidth);
    } else {
        $('#tpTableWidth').val('100%');
    }

    var firstCell = $table.find('td, th').first();
    var curPad = firstCell.length ? firstCell.css('padding-top') : '10px';
    if (parseInt(curPad) <= 2) {
        $('#tpCellPadding').val('none');
    } else if (parseInt(curPad) <= 6) {
        $('#tpCellPadding').val('compact');
    } else if (parseInt(curPad) >= 16) {
        $('#tpCellPadding').val('spacious');
    } else {
        $('#tpCellPadding').val('normal');
    }

    var marginLeft = $table[0].style.marginLeft;
    var marginRight = $table[0].style.marginRight;
    if (marginLeft === 'auto' && marginRight === 'auto') {
        $('#tpTableAlign').val('center');
    } else if (marginLeft === 'auto') {
        $('#tpTableAlign').val('right');
    } else {
        $('#tpTableAlign').val('left');
    }

    $('#tpStripedRows').prop('checked', $table.hasClass('table-striped'));

    var modal = new bootstrap.Modal(document.getElementById('modalTableProperties'), {
        backdrop: 'static'
    });
    modal.show();
}

function applyTableProperties() {
    var $table = getTargetTable(activeEditorContext);
    if (!$table || !$table.length) return;

    var borderStyle = $('#tpBorderStyle').val();
    var borderWidth = $('#tpBorderWidth').val();
    var borderColor = $('#tpBorderColor').val() || '#c29958';
    var tableWidth = $('#tpTableWidth').val();
    var cellPaddingPreset = $('#tpCellPadding').val();
    var tableAlign = $('#tpTableAlign').val();
    var isStriped = $('#tpStripedRows').is(':checked');

    if (borderStyle === 'none' || borderWidth === '0px') {
        stripAllTableBorders($table);
    } else {
        $table.removeClass('table-borderless no-border').removeAttr('data-borderless');
        var borderVal = borderWidth + ' ' + borderStyle + ' ' + borderColor;
        $table.css({
            'border': borderVal,
            'border-collapse': 'collapse'
        });
        $table.find('thead, tbody, tfoot, tr').each(function() {
            this.style.removeProperty('border');
            this.style.removeProperty('border-top');
            this.style.removeProperty('border-bottom');
            this.style.removeProperty('border-left');
            this.style.removeProperty('border-right');
            this.style.removeProperty('box-shadow');
        });
        $table.find('td, th').each(function() {
            this.style.setProperty('border', borderVal, 'important');
            $(this).removeClass('no-border');
        });
    }

    if (tableWidth) {
        $table.css('width', tableWidth);
    }

    if (tableAlign === 'center') {
        $table.css({ 'margin-left': 'auto', 'margin-right': 'auto' });
    } else if (tableAlign === 'right') {
        $table.css({ 'margin-left': 'auto', 'margin-right': '0' });
    } else {
        $table.css({ 'margin-left': '0', 'margin-right': 'auto' });
    }

    var padVal = '10px 14px';
    if (cellPaddingPreset === 'none') padVal = '0px';
    else if (cellPaddingPreset === 'compact') padVal = '4px 8px';
    else if (cellPaddingPreset === 'spacious') padVal = '16px 20px';
    $table.find('td, th').css('padding', padVal);

    if (isStriped) {
        $table.addClass('table-striped');
        $table.find('tr:nth-child(even)').css('background-color', 'rgba(255, 255, 255, 0.04)');
    } else {
        $table.removeClass('table-striped');
        $table.find('tr').css('background-color', '');
    }

    var modalEl = document.getElementById('modalTableProperties');
    var modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    if (activeEditorContext && activeEditorContext.invoke) {
        try { activeEditorContext.invoke('editor.afterCommand'); } catch(e) {}
    }
    $('.summernote-editor').trigger('summernote.change');
    showTableToast(borderStyle === 'none' || borderWidth === '0px' ? 'All table borders removed completely!' : 'Table properties updated!');
}

var makeTablePropertiesBtn = function(context) {
    var ui = $.summernote.ui;
    return ui.button({
        contents: '<i class="fa-solid fa-table-cells text-warning"></i> <span class="d-none d-md-inline ms-1">Table Props</span>',
        tooltip: 'Table Properties & Border Settings',
        click: function() {
            openTablePropertiesModal(context);
        }
    }).render();
};

// Initialize Summernote Rich Text Editors
$(document).ready(function() {
    if ($.fn && $.fn.summernote) {
        $('.summernote-editor').summernote({
            placeholder: 'Write formatted content here...',
            tabsize: 2,
            height: 250,
            tableClassName: 'table',
            buttons: {
                tableProperties: makeTablePropertiesBtn
            },
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table', 'tableProperties']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            popover: {
                table: [
                    ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                    ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                    ['custom', ['tableProperties']]
                ]
            }
        });
    }

    // Ensure Summernote modal backdrop never covers or blocks the screen
    $(document).on('note.modal.show', function() {
        $('.note-modal-backdrop').remove();
    });
    $(document).on('click', '.note-btn', function() {
        setTimeout(function() {
            $('.note-modal-backdrop').remove();
        }, 30);
    });
    // Click outside modal content to close Summernote modal
    $(document).on('click', '.note-modal', function(e) {
        if ($(e.target).hasClass('note-modal')) {
            $(this).find('.close, .note-close').trigger('click');
            $('.note-modal-backdrop').remove();
        }
    });

    // Sync Summernote rich text to underlying textarea before form submit
    $('form').on('submit', function() {
        if ($.fn && $.fn.summernote) {
            $(this).find('.summernote-editor').each(function() {
                try {
                    $(this).val($(this).summernote('code'));
                } catch(e) {}
            });
        }
    });

    // Delegated click handlers for edit buttons
    $(document).on('click', '.btn-edit-blog', function() {
        const id = $(this).data('id');
        if (typeof triggerEditBlog === 'function') {
            triggerEditBlog(id);
        }
    });

    $(document).on('click', '.btn-edit-service', function() {
        const id = $(this).data('id');
        if (typeof triggerEditService === 'function') {
            triggerEditService(id);
        }
    });

    $(document).on('click', '.btn-edit-hero-slide', function() {
        const id = $(this).data('id');
        if (typeof triggerEditHeroSlide === 'function') {
            triggerEditHeroSlide(id);
        }
    });
});

// ==========================================
// HERO SLIDES MODAL HANDLERS
// ==========================================
function openNewHeroSlideModal() {
    $('#heroSlideModalTitle').text('Add Hero Banner Slide');
    $('#heroSlideSubmitBtn').text('Add Slide');
    $('#heroSlideId').val(0);
    $('#heroSlideLayoutNum').val(<?= $curr_layout ?>);
    $('#heroSlideBadge').val('True Beauty Starts with Healthy Skin');
    $('#heroSlideTitle').val('Glow Starts with <br> Healthy Skin');
    $('#heroSlideDesc').val('Healthy skin is the true foundation of lasting beauty.');
    $('#heroSlideBtnText').val('Book Appointment');
    $('#heroSlideBtnUrl').val('booking');
    $('#heroSlideImageUrl').val('assets/template2/images/resources/main-slider-img-1-1.png');
    $('#heroSlideBgUrl').val('');
    $('#heroSlideSortOrder').val(<?= !empty($hero_slides) ? (count($hero_slides) + 1) : 1 ?>);
    $('#heroSlideStatus').val('active');

    const modalEl = document.getElementById('modalHeroSlide');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function triggerEditHeroSlide(id) {
    const el = document.getElementById('heroSlideData_' + id);
    if (el) {
        try {
            const data = JSON.parse(el.textContent);
            openEditHeroSlideModal(data);
        } catch(e) {
            console.error('Error parsing hero slide data for #' + id, e);
        }
    }
}

function openEditHeroSlideModal(slide) {
    if (typeof slide === 'string') {
        try { slide = JSON.parse(slide); } catch(e) {}
    }
    if (!slide) return;

    $('#heroSlideModalTitle').text('Edit Hero Slide #' + (slide.sort_order || slide.id));
    $('#heroSlideSubmitBtn').text('Update Slide');
    $('#heroSlideId').val(slide.id || 0);
    $('#heroSlideLayoutNum').val(slide.layout_number || <?= $curr_layout ?>);
    $('#heroSlideBadge').val(slide.badge || '');
    $('#heroSlideTitle').val(slide.title || '');
    $('#heroSlideDesc').val(slide.description || '');
    $('#heroSlideBtnText').val(slide.button_text || 'Book Appointment');
    $('#heroSlideBtnUrl').val(slide.button_url || 'booking');
    $('#heroSlideImageUrl').val(slide.image || '');
    $('#heroSlideBgUrl').val(slide.background_image || '');
    $('#heroSlideSortOrder').val(slide.sort_order || 1);
    $('#heroSlideStatus').val(slide.status || 'active');

    const modalEl = document.getElementById('modalHeroSlide');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function deleteHeroSlide(id) {
    if (confirm('Are you sure you want to delete this hero slide?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseSuperUrl + 'layouts';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_hero_slide">
            <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
            <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
            <input type="hidden" name="active_section" value="hero">
            <input type="hidden" name="slide_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// ==========================================
// FEATURED SKINCARE MODAL HANDLERS
// ==========================================
function openNewFeaturedModal() {
    const layoutNum = <?= (int)$curr_layout ?>;
    const label = layoutNum === 2 ? 'Our Works Item' : (layoutNum === 1 ? 'Featured Skincare Item' : 'Feature Item');
    $('#featModalTitle').text('Add ' + label);
    $('#featItemId').val(0);
    $('#featLayoutNum').val(layoutNum);
    $('#featTitle').val('');
    $('#featShortDesc').val('');
    $('#featThumbnailUrl').val('');
    $('#featSortOrder').val(1);
    $('#featStatus').val('active');
}

function openEditFeaturedModal(item) {
    const layoutNum = item.layout_number || <?= (int)$curr_layout ?>;
    const label = layoutNum === 2 ? 'Our Works Item' : (layoutNum === 1 ? 'Featured Skincare Item' : 'Feature Item');
    $('#featModalTitle').text('Edit ' + label + ': ' + item.title);
    $('#featItemId').val(item.id);
    $('#featLayoutNum').val(layoutNum);
    $('#featTitle').val(item.title);
    $('#featShortDesc').val(item.short_desc);
    $('#featThumbnailUrl').val(item.thumbnail);
    $('#featSortOrder').val(item.sort_order);
    $('#featStatus').val(item.status);
    const m = new bootstrap.Modal(document.getElementById('modalFeaturedItem'));
    m.show();
}

function deleteFeaturedItem(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseSuperUrl + 'layouts';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_featured_item">
            <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
            <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
            <input type="hidden" name="active_section" value="skincare">
            <input type="hidden" name="item_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// ==========================================
// SERVICE MODAL HANDLERS
// ==========================================
function openNewServiceModal() {
    $('#svcModalTitle').text('Add New Service (Layout <?= $curr_layout ?>)');
    $('#svcId').val(0);
    $('#svcLayoutNum').val(<?= (int)$curr_layout ?>);
    $('#svcTitle').val('');
    $('#svcSlug').val('');
    $('#svcThumbUrl').val('assets/template2/images/services/services-1-1.jpg');
    $('#svcBannerUrl').val('assets/template2/images/services/service-details-img4.jpg');
    $('#svcPrice').val('85.00');
    $('#svcDuration').val('60 mins');
    if ($.fn && $.fn.summernote) {
        try {
            $('#svcDescriptionEditor').summernote('code', '<p>Detailed description of the service and treatments offered...</p><h4>Key Treatment Highlights</h4><ul><li>Nourishing hydration and natural renewal</li><li>Deep pore purifying care</li></ul>');
        } catch(e) {
            $('#svcDescriptionEditor').val('<p>Detailed description of the service and treatments offered...</p><h4>Key Treatment Highlights</h4><ul><li>Nourishing hydration and natural renewal</li><li>Deep pore purifying care</li></ul>');
        }
    } else {
        $('#svcDescriptionEditor').val('<p>Detailed description of the service and treatments offered...</p><h4>Key Treatment Highlights</h4><ul><li>Nourishing hydration and natural renewal</li><li>Deep pore purifying care</li></ul>');
    }
    $('#svcSortOrder').val(1);
    $('#svcStatus').val('active');
}

function triggerEditService(id) {
    const el = document.getElementById('svcData_' + id);
    if (el) {
        try {
            const data = JSON.parse(el.textContent);
            openEditServiceModal(data);
        } catch(e) {
            console.error('Error parsing service data for #' + id, e);
        }
    }
}

function openEditServiceModal(svc) {
    if (typeof svc === 'string') {
        try { svc = JSON.parse(svc); } catch(e) {}
    }
    if (!svc) return;

    $('#svcModalTitle').text('Edit Service: ' + (svc.title || '') + ' (Layout ' + (svc.layout_number || <?= (int)$curr_layout ?>) + ')');
    $('#svcId').val(svc.id || 0);
    $('#svcLayoutNum').val(svc.layout_number || <?= (int)$curr_layout ?>);
    $('#svcTitle').val(svc.title || '');
    $('#svcSlug').val(svc.slug || '');
    $('#svcThumbUrl').val(svc.thumbnail || '');
    $('#svcBannerUrl').val(svc.banner_image || '');
    $('#svcPrice').val(svc.price || '');
    $('#svcDuration').val(svc.duration || '60 mins');
    $('#svcShortDesc').val(svc.short_desc || '');
    
    if ($.fn && $.fn.summernote) {
        try {
            $('#svcDescriptionEditor').summernote('code', svc.description || '');
        } catch(e) {
            $('#svcDescriptionEditor').val(svc.description || '');
        }
    } else {
        $('#svcDescriptionEditor').val(svc.description || '');
    }

    $('#svcSortOrder').val(svc.sort_order || 0);
    $('#svcStatus').val(svc.status || 'active');

    const modalEl = document.getElementById('modalService');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function deleteService(id) {
    if (confirm('Are you sure you want to delete this service?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseSuperUrl + 'layouts';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_service">
            <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
            <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
            <input type="hidden" name="active_section" value="services">
            <input type="hidden" name="service_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// ==========================================
// TESTIMONIAL MODAL HANDLERS
// ==========================================
function openNewTestimonialModal() {
    $('#testiModalTitle').text('Add Testimonial');
    $('#testiId').val(0);
    $('#testiName').val('');
    $('#testiDesignation').val('');
    $('#testiRating').val('5');
    $('#testiReview').val('');
    $('#testiAvatarUrl').val('assets/template2/images/testimonial/testimonial-v1-img1.jpg');
    $('#testiSortOrder').val(1);
    $('#testiStatus').val('active');
}

function openEditTestimonialModal(tst) {
    $('#testiModalTitle').text('Edit Testimonial: ' + tst.client_name);
    $('#testiId').val(tst.id);
    $('#testiName').val(tst.client_name);
    $('#testiDesignation').val(tst.designation);
    $('#testiRating').val(tst.rating);
    $('#testiReview').val(tst.review);
    $('#testiAvatarUrl').val(tst.avatar);
    $('#testiSortOrder').val(tst.sort_order);
    $('#testiStatus').val(tst.status);
    const m = new bootstrap.Modal(document.getElementById('modalTestimonial'));
    m.show();
}

function deleteTestimonial(id) {
    if (confirm('Delete this client testimonial?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseSuperUrl + 'layouts';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_testimonial">
            <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
            <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
            <input type="hidden" name="active_section" value="testimonials">
            <input type="hidden" name="testimonial_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// ==========================================
// FAQ MODAL HANDLERS
// ==========================================
function openNewFaqModal() {
    $('#faqModalTitle').text('Add FAQ Item (Layout <?= $curr_layout ?>)');
    $('#faqId').val(0);
    $('#faqLayoutNum').val(<?= (int)$curr_layout ?>);
    $('#faqQuestion').val('');
    $('#faqAnswer').val('');
    $('#faqSortOrder').val(1);
    $('#faqStatus').val('active');
}

function openEditFaqModal(fq) {
    $('#faqModalTitle').text('Edit FAQ (Layout ' + (fq.layout_number || <?= (int)$curr_layout ?>) + ')');
    $('#faqId').val(fq.id);
    $('#faqLayoutNum').val(fq.layout_number || <?= (int)$curr_layout ?>);
    $('#faqQuestion').val(fq.question);
    $('#faqAnswer').val(fq.answer);
    $('#faqSortOrder').val(fq.sort_order);
    $('#faqStatus').val(fq.status);
    const m = new bootstrap.Modal(document.getElementById('modalFaq'));
    m.show();
}

function deleteFaq(id) {
    if (confirm('Delete this FAQ item?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseSuperUrl + 'layouts';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_faq">
            <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
            <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
            <input type="hidden" name="active_section" value="faqs">
            <input type="hidden" name="faq_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// ==========================================
// BLOG MODAL HANDLERS
// ==========================================
function openNewBlogModal() {
    $('#blogModalTitle').text('Publish Blog Article');
    $('#blogSubmitBtn').text('Publish Article');
    $('#blogId').val(0);
    $('#blogTitle').val('');
    $('#blogSlug').val('');
    $('#blogAuthor').val('Admin');
    $('#blogDate').val(new Date().toISOString().slice(0, 10));
    $('#blogTags').val('Skincare, Wellness, Beauty');
    $('#blogThumbUrl').val('assets/template2/images/blog/blog-v1-img1.jpg');
    $('#blogShortDesc').val('');
    
    if ($.fn && $.fn.summernote) {
        try {
            $('#blogContentEditor').summernote('code', '<p>Write your complete article content here...</p><h4>1. Master Key Routines</h4><p>Details about treatments and skincare wellness.</p>');
        } catch(e) {
            $('#blogContentEditor').val('<p>Write your complete article content here...</p><h4>1. Master Key Routines</h4><p>Details about treatments and skincare wellness.</p>');
        }
    } else {
        $('#blogContentEditor').val('<p>Write your complete article content here...</p><h4>1. Master Key Routines</h4><p>Details about treatments and skincare wellness.</p>');
    }
    
    $('#blogSortOrder').val(1);
    $('#blogStatus').val('active');
    $('#blogLayoutNumber').val(<?= $curr_layout ?>);
    
    const modalEl = document.getElementById('modalBlog');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function triggerEditBlog(id) {
    const el = document.getElementById('blogData_' + id);
    if (el) {
        try {
            const data = JSON.parse(el.textContent);
            openEditBlogModal(data);
        } catch(e) {
            console.error('Error parsing blog data for #' + id, e);
        }
    }
}

function openEditBlogModal(blg) {
    if (typeof blg === 'string') {
        try { blg = JSON.parse(blg); } catch(e) {}
    }
    if (!blg) return;

    $('#blogModalTitle').text('Edit Article: ' + (blg.title || ''));
    $('#blogSubmitBtn').text('Update Article');
    $('#blogId').val(blg.id || 0);
    $('#blogTitle').val(blg.title || '');
    $('#blogSlug').val(blg.slug || '');
    $('#blogAuthor').val(blg.author_name || 'Admin');
    $('#blogDate').val(blg.published_date || '');
    $('#blogTags').val(blg.tags || '');
    $('#blogThumbUrl').val(blg.thumbnail || '');
    $('#blogShortDesc').val(blg.short_desc || '');
    
    if ($.fn && $.fn.summernote) {
        try {
            $('#blogContentEditor').summernote('code', blg.content || '');
        } catch(e) {
            $('#blogContentEditor').val(blg.content || '');
        }
    } else {
        $('#blogContentEditor').val(blg.content || '');
    }
    
    $('#blogSortOrder').val(blg.sort_order || 1);
    $('#blogStatus').val(blg.status || 'active');
    $('#blogLayoutNumber').val(blg.layout_number || <?= $curr_layout ?>);

    const modalEl = document.getElementById('modalBlog');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function deleteBlog(id) {
    if (confirm('Delete this blog article?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseSuperUrl + 'layouts';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_blog">
            <input type="hidden" name="active_tab" value="<?= htmlspecialchars($curr_target_tpl) ?>">
            <input type="hidden" name="active_layout" value="<?= $curr_layout ?>">
            <input type="hidden" name="active_section" value="blogs">
            <input type="hidden" name="blog_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// ==========================================
// ARCHITECTURE MODAL HANDLERS
// ==========================================
function openNewTemplateModal() {
    $('#tplModalTitle').text('Add New Template');
    $('#tplId').val(0);
    $('#tplKey').val('').prop('readonly', false);
    $('#tplName').val('');
    $('#tplBadge').val('');
    $('#tplIcon').val('fa-solid fa-crown');
    $('#tplShortDesc').val('');
    $('#tplFeatures').val('');
    $('#tplSortOrder').val(1);
    $('#tplStatus').val('active');
}

function openEditTemplateModal(tpl) {
    $('#tplModalTitle').text('Edit Template: ' + tpl.name);
    $('#tplId').val(tpl.id);
    $('#tplKey').val(tpl.template_key).prop('readonly', true);
    $('#tplName').val(tpl.name);
    $('#tplBadge').val(tpl.badge || '');
    $('#tplIcon').val(tpl.icon || 'fa-solid fa-crown');
    $('#tplShortDesc').val(tpl.short_desc || '');
    let feats = '';
    if (tpl.features) {
        try {
            const arr = JSON.parse(tpl.features);
            if (Array.isArray(arr)) feats = arr.join("\n");
        } catch(e){}
    }
    $('#tplFeatures').val(feats);
    $('#tplSortOrder').val(tpl.sort_order || 1);
    $('#tplStatus').val(tpl.status || 'active');
    const m = new bootstrap.Modal(document.getElementById('modalTemplate'));
    m.show();
}

function deleteTemplate(id) {
    if (confirm('Warning: Deleting this template will also remove all its layout configurations! Proceed?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseSuperUrl + 'layouts';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_template">
            <input type="hidden" name="active_tab" value="multi-theme">
            <input type="hidden" name="template_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function openNewLayoutModal(tplId, tplKey, tplName, nextNum) {
    $('#layoutModalTitle').text('Add Layout to ' + tplName);
    $('#layoutId').val(0);
    $('#layoutTemplateId').val(tplId);
    $('#layoutParentName').text(tplName);
    $('#layoutNumber').val(nextNum);
    $('#layoutName').val('Layout ' + nextNum);
    $('#layoutPreviewImageUrl').val('');
    $('#layoutDemoUrl').val('website/?preview_tpl=' + tplKey + '&preview_layout=' + nextNum);
    $('#layoutSortOrder').val(nextNum);
    $('#layoutStatus').val('active');
    const m = new bootstrap.Modal(document.getElementById('modalLayout'));
    m.show();
}

function openEditLayoutModal(l, tplName) {
    $('#layoutModalTitle').text('Edit Layout: ' + l.layout_name);
    $('#layoutId').val(l.id);
    $('#layoutTemplateId').val(l.template_id);
    $('#layoutParentName').text(tplName);
    $('#layoutNumber').val(l.layout_number);
    $('#layoutName').val(l.layout_name);
    $('#layoutPreviewImageUrl').val(l.preview_image);
    $('#layoutDemoUrl').val(l.demo_url);
    $('#layoutSortOrder').val(l.sort_order);
    $('#layoutStatus').val(l.status);
    const m = new bootstrap.Modal(document.getElementById('modalLayout'));
    m.show();
}

function deleteLayout(id) {
    if (confirm('Delete this layout configuration?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = baseSuperUrl + 'layouts';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_layout">
            <input type="hidden" name="active_tab" value="multi-theme">
            <input type="hidden" name="layout_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function openLayoutPreviewModal(layout, tplName) {
    document.getElementById('pvLayoutTitle').textContent = layout.layout_name || 'Layout Preview';
    document.getElementById('pvLayoutSubtitle').textContent = (tplName ? tplName + ' • ' : '') + 'Layout ' + (layout.layout_number || 1);

    let demoUrl = layout.demo_url;
    if (!demoUrl || demoUrl.trim() === '') {
        demoUrl = 'website/?preview_tpl=' + (layout.template_key || '') + '&preview_layout=' + (layout.layout_number || 1);
    }
    const fullDemoUrl = resolveMainUrl(demoUrl);
    document.getElementById('pvLaunchExternal').href = fullDemoUrl;

    const spinner = document.getElementById('pvLoading');
    if (spinner) spinner.style.display = 'block';
    const iframe = document.getElementById('pvIframe');
    if (iframe) iframe.src = fullDemoUrl;

    let imgUrl = layout.preview_image;
    const fullImgUrl = (imgUrl && imgUrl.trim() !== '') ? resolveMainUrl(imgUrl) : (mainSiteUrl + 'uploads/no-image.jpg');
    const pvImg = document.getElementById('pvImage');
    if (pvImg) pvImg.src = fullImgUrl;

    setPreviewDevice('100%', document.querySelector('#pvDeviceGroup button'));
    setPreviewMode('live');

    const modal = new bootstrap.Modal(document.getElementById('modalPreviewLayout'));
    modal.show();
}

function setPreviewDevice(width, btn) {
    const wrapper = document.getElementById('pvFrameWrapper');
    if (wrapper) wrapper.style.width = width;
    const group = document.getElementById('pvDeviceGroup');
    if (group) {
        group.querySelectorAll('button').forEach(b => {
            b.classList.remove('active', 'btn-dark', 'text-warning');
            b.classList.add('btn-outline-secondary', 'text-light');
        });
    }
    if (btn) {
        btn.classList.remove('btn-outline-secondary', 'text-light');
        btn.classList.add('active', 'btn-dark', 'text-warning');
    }
}

function setPreviewMode(mode) {
    const frameWrap = document.getElementById('pvFrameWrapper');
    const imgWrap = document.getElementById('pvImageWrapper');
    const btnLive = document.getElementById('pvModeLive');
    const btnImage = document.getElementById('pvModeImage');
    const devGroup = document.getElementById('pvDeviceGroup');

    if (mode === 'image') {
        if (frameWrap) frameWrap.style.display = 'none';
        if (imgWrap) imgWrap.style.display = 'block';
        if (btnImage) {
            btnImage.classList.add('active', 'btn-warning', 'text-dark');
            btnImage.classList.remove('btn-outline-warning');
        }
        if (btnLive) {
            btnLive.classList.remove('active', 'btn-warning', 'text-dark');
            btnLive.classList.add('btn-outline-warning');
        }
        if (devGroup) devGroup.style.display = 'none';
    } else {
        if (frameWrap) frameWrap.style.display = 'block';
        if (imgWrap) imgWrap.style.display = 'none';
        if (btnLive) {
            btnLive.classList.add('active', 'btn-warning', 'text-dark');
            btnLive.classList.remove('btn-outline-warning');
        }
        if (btnImage) {
            btnImage.classList.remove('active', 'btn-warning', 'text-dark');
            btnImage.classList.add('btn-outline-warning');
        }
        if (devGroup) devGroup.style.display = 'inline-flex';
    }
}

const modalPreviewEl = document.getElementById('modalPreviewLayout');
if (modalPreviewEl) {
    modalPreviewEl.addEventListener('hidden.bs.modal', function () {
        const iframe = document.getElementById('pvIframe');
        if (iframe) iframe.src = 'about:blank';
    });
}
</script>
