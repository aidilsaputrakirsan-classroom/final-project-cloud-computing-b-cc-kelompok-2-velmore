<style>
/* ==========================================================
   🎨 PREMIUM FORM DESIGN - ULTRA MODERN & CLEAN
   ========================================================== */

/* === CSS RESET & BASE === */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* === THEME VARIABLES === */
:root {
    /* Dark Theme (Default) */
    --bg-gradient-start: #0f172a;
    --bg-gradient-end: #1e293b;
    --bg-card: #1e293b;
    --bg-card-hover: #273548;
    --bg-input: #0f172a;
    --bg-input-focus: #1e293b;
    --bg-info: rgba(139, 92, 246, 0.08);
    --bg-badge: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    
    /* Borders */
    --border-primary: rgba(139, 92, 246, 0.2);
    --border-secondary: rgba(148, 163, 184, 0.1);
    --border-focus: rgba(139, 92, 246, 0.5);
    --border-info: rgba(139, 92, 246, 0.3);
    
    /* Text Colors */
    --text-primary: #f1f5f9;
    --text-secondary: #cbd5e1;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    --text-label: #c4b5fd;
    --text-info: #e9d5ff;
    
    /* Accent Colors */
    --accent-primary: #8b5cf6;
    --accent-secondary: #a78bfa;
    --accent-tertiary: #c4b5fd;
    --accent-success: #10b981;
    --accent-warning: #f59e0b;
    --accent-error: #ef4444;
    
    /* Shadows */
    --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
    --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.25);
    --shadow-xl: 0 20px 50px rgba(0, 0, 0, 0.35);
    --shadow-glow: 0 0 30px rgba(139, 92, 246, 0.3);
    --shadow-button: 0 4px 20px rgba(139, 92, 246, 0.4);
    
    /* Transitions */
    --transition-fast: 0.15s ease;
    --transition-base: 0.3s ease;
    --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    
    /* Spacing */
    --spacing-xs: 4px;
    --spacing-sm: 8px;
    --spacing-md: 16px;
    --spacing-lg: 24px;
    --spacing-xl: 32px;
    --spacing-2xl: 48px;
    
    /* Border Radius */
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --radius-full: 9999px;
}

/* === LIGHT THEME === */
@media (prefers-color-scheme: light) {
    :root {
        --bg-gradient-start: #f8fafc;
        --bg-gradient-end: #e2e8f0;
        --bg-card: #ffffff;
        --bg-card-hover: #f8fafc;
        --bg-input: #f1f5f9;
        --bg-input-focus: #ffffff;
        --bg-info: rgba(99, 102, 241, 0.05);
        --bg-badge: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        
        --border-primary: rgba(99, 102, 241, 0.3);
        --border-secondary: #e2e8f0;
        --border-focus: rgba(99, 102, 241, 0.6);
        --border-info: rgba(99, 102, 241, 0.2);
        
        --text-primary: #0f172a;
        --text-secondary: #334155;
        --text-tertiary: #64748b;
        --text-muted: #94a3b8;
        --text-label: #6366f1;
        --text-info: #4338ca;
        
        --accent-primary: #6366f1;
        --accent-secondary: #818cf8;
        --accent-tertiary: #a5b4fc;
        
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
        --shadow-xl: 0 20px 50px rgba(0, 0, 0, 0.15);
        --shadow-glow: 0 0 30px rgba(99, 102, 241, 0.2);
        --shadow-button: 0 4px 20px rgba(99, 102, 241, 0.3);
    }
}

/* === DARK MODE OVERRIDE === */
body.dark-mode {
    --bg-gradient-start: #0f172a;
    --bg-gradient-end: #1e293b;
    --bg-card: #1e293b;
    --bg-card-hover: #273548;
    --bg-input: #0f172a;
    --bg-input-focus: #1e293b;
    --bg-info: rgba(139, 92, 246, 0.08);
    --bg-badge: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    
    --border-primary: rgba(139, 92, 246, 0.2);
    --border-secondary: rgba(148, 163, 184, 0.1);
    --border-focus: rgba(139, 92, 246, 0.5);
    --border-info: rgba(139, 92, 246, 0.3);
    
    --text-primary: #f1f5f9;
    --text-secondary: #cbd5e1;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    --text-label: #c4b5fd;
    --text-info: #e9d5ff;
    
    --accent-primary: #8b5cf6;
    --accent-secondary: #a78bfa;
    --accent-tertiary: #c4b5fd;
}

/* === BODY & CONTAINER === */
body {
    background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
    line-height: 1.6;
    color: var(--text-primary);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-lg);
    position: relative;
    overflow-x: hidden;
}

/* Animated Background Pattern */
body::before {
    content: '';
    position: fixed;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, var(--accent-primary) 1px, transparent 1px);
    background-size: 50px 50px;
    opacity: 0.03;
    animation: patternMove 60s linear infinite;
    pointer-events: none;
    z-index: 0;
}

@keyframes patternMove {
    0% {
        transform: translate(0, 0) rotate(0deg);
    }
    100% {
        transform: translate(50px, 50px) rotate(360deg);
    }
}

/* Main Container */
.container {
    width: 100%;
    max-width: 750px;
    position: relative;
    z-index: 1;
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* === CARD COMPONENT === */
.category-card {
    background: var(--bg-card);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-primary);
    padding: var(--spacing-2xl);
    box-shadow: var(--shadow-xl);
    position: relative;
    overflow: hidden;
    transition: all var(--transition-slow);
}

/* Card Glow Effect */
.category-card::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary), var(--accent-primary));
    border-radius: var(--radius-xl);
    z-index: -1;
    opacity: 0;
    transition: opacity var(--transition-base);
    filter: blur(10px);
}

.category-card:hover::before {
    opacity: 0.5;
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl), var(--shadow-glow);
}

/* === PAGE TITLE === */
.page-title {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 800;
    margin: 0 0 var(--spacing-xl) 0;
    letter-spacing: -0.03em;
    background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    display: inline-block;
    animation: titleGlow 3s ease-in-out infinite;
}

@keyframes titleGlow {
    0%, 100% {
        filter: drop-shadow(0 0 10px rgba(139, 92, 246, 0.3));
    }
    50% {
        filter: drop-shadow(0 0 20px rgba(139, 92, 246, 0.5));
    }
}

.page-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, var(--accent-primary), transparent);
    border-radius: var(--radius-full);
}

/* === INFO BOX === */
.info-box {
    background: var(--bg-info);
    border: 1px solid var(--border-info);
    border-left: 4px solid var(--accent-primary);
    border-radius: var(--radius-md);
    padding: var(--spacing-md) var(--spacing-lg);
    margin-bottom: var(--spacing-xl);
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-md);
    position: relative;
    overflow: hidden;
    transition: all var(--transition-base);
}

.info-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, var(--accent-primary), var(--accent-secondary));
    transition: width var(--transition-base);
}

.info-box:hover::before {
    width: 100%;
    opacity: 0.1;
}

.info-box-icon {
    color: var(--accent-primary);
    font-size: 20px;
    flex-shrink: 0;
    margin-top: 2px;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.info-box-text {
    color: var(--text-info);
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0;
    flex: 1;
}

/* === ID BADGE === */
.id-badge {
    background: var(--bg-badge);
    padding: 10px 20px;
    color: #ffffff;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    margin-bottom: var(--spacing-lg);
    box-shadow: var(--shadow-button);
    letter-spacing: 0.05em;
    text-transform: uppercase;
    position: relative;
    overflow: hidden;
    transition: all var(--transition-base);
}

.id-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s;
}

.id-badge:hover::before {
    left: 100%;
}

.id-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(139, 92, 246, 0.5);
}

/* === FORM ELEMENTS === */
.form-group {
    margin-bottom: var(--spacing-xl);
    position: relative;
}

/* Form Label */
.form-label-custom {
    color: var(--text-label);
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.12em;
    margin-bottom: var(--spacing-md);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    position: relative;
}

.form-label-custom::before {
    content: '';
    width: 3px;
    height: 16px;
    background: linear-gradient(180deg, var(--accent-primary), var(--accent-secondary));
    border-radius: var(--radius-full);
}

/* Input Field */
.form-input {
    width: 100%;
    background: var(--bg-input);
    color: var(--text-primary);
    border: 2px solid var(--border-secondary);
    border-radius: var(--radius-md);
    padding: 16px 20px;
    font-size: 1rem;
    font-family: inherit;
    transition: all var(--transition-base);
    outline: none;
    position: relative;
}

.form-input::placeholder {
    color: var(--text-muted);
    opacity: 0.6;
}

.form-input:hover {
    background: var(--bg-input-focus);
    border-color: var(--border-primary);
}

.form-input:focus {
    background: var(--bg-input-focus);
    border-color: var(--accent-primary);
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1), var(--shadow-md);
    transform: translateY(-1px);
}

.form-input:focus::placeholder {
    opacity: 0.4;
    transform: translateX(5px);
}

/* Input with icon */
.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-tertiary);
    pointer-events: none;
    transition: all var(--transition-base);
}

.form-input:focus ~ .input-icon {
    color: var(--accent-primary);
    transform: translateY(-50%) scale(1.1);
}

/* Helper Text */
.form-helper {
    color: var(--text-tertiary);
    font-size: 0.8rem;
    margin-top: var(--spacing-sm);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding-left: var(--spacing-sm);
    transition: all var(--transition-base);
}

.form-helper-icon {
    font-size: 14px;
    color: var(--accent-primary);
}

.form-input:focus ~ .form-helper {
    color: var(--text-secondary);
    transform: translateX(4px);
}

/* === BUTTONS === */
.button-container {
    display: flex;
    gap: var(--spacing-md);
    margin-top: var(--spacing-2xl);
    flex-wrap: wrap;
}

/* Primary Button (Save/Update) */
.btn-save,
.btn-update {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    padding: 16px 36px;
    border-radius: var(--radius-md);
    border: none;
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-button);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
    position: relative;
    overflow: hidden;
    letter-spacing: 0.02em;
    text-transform: uppercase;
    font-size: 0.85rem;
}

.btn-save::before,
.btn-update::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s;
}

.btn-save:hover::before,
.btn-update:hover::before {
    left: 100%;
}

.btn-save:hover,
.btn-update:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
}

.btn-save:active,
.btn-update:active {
    transform: translateY(-1px);
}

.btn-save .btn-icon,
.btn-update .btn-icon {
    font-size: 18px;
    transition: transform var(--transition-base);
}

.btn-save:hover .btn-icon,
.btn-update:hover .btn-icon {
    transform: scale(1.2) rotate(10deg);
}

/* Secondary Button (Back) */
.btn-back {
    background: var(--bg-card-hover);
    border: 2px solid var(--border-primary);
    color: var(--text-primary);
    padding: 16px 36px;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all var(--transition-base);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
    letter-spacing: 0.02em;
    text-transform: uppercase;
}

.btn-back:hover {
    background: var(--bg-input);
    border-color: var(--accent-primary);
    color: var(--accent-primary);
    transform: translateX(-5px);
    box-shadow: var(--shadow-md);
}

.btn-back .btn-icon {
    font-size: 18px;
    transition: transform var(--transition-base);
}

.btn-back:hover .btn-icon {
    transform: translateX(-5px);
}

/* Button Loading State */
.btn-loading {
    pointer-events: none;
    opacity: 0.7;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* === VALIDATION STATES === */
.form-input.is-valid {
    border-color: var(--accent-success);
}

.form-input.is-valid:focus {
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1), var(--shadow-md);
}

.form-input.is-invalid {
    border-color: var(--accent-error);
}

.form-input.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1), var(--shadow-md);
}

.form-feedback {
    font-size: 0.8rem;
    margin-top: var(--spacing-sm);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.form-feedback.valid {
    color: var(--accent-success);
}

.form-feedback.invalid {
    color: var(--accent-error);
}

/* === RESPONSIVE DESIGN === */
@media (max-width: 768px) {
    body {
        padding: var(--spacing-md);
    }
    
    .category-card {
        padding: var(--spacing-lg);
        border-radius: var(--radius-lg);
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .button-container {
        flex-direction: column;
    }
    
    .btn-save,
    .btn-update,
    .btn-back {
        width: 100%;
    }
    
    .info-box {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .category-card {
        padding: var(--spacing-md);
    }
    
    .page-title {
        font-size: 1.25rem;
    }
    
    .form-input {
        padding: 14px 16px;
        font-size: 0.95rem;
    }
    
    .btn-save,
    .btn-update,
    .btn-back {
        padding: 14px 28px;
        font-size: 0.8rem;
    }
}

/* === ACCESSIBILITY === */
.btn-save:focus-visible,
.btn-update:focus-visible,
.btn-back:focus-visible {
    outline: 3px solid var(--accent-primary);
    outline-offset: 3px;
}

.form-input:focus-visible {
    outline: none;
}

/* Reduce motion for users who prefer it */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* === PRINT STYLES === */
@media print {
    body {
        background: white;
    }
    
    .category-card {
        box-shadow: none;
        border: 1px solid #000;
    }
    
    .btn-save,
    .btn-update,
    .btn-back {
        display: none;
    }
}

/* === SMOOTH TRANSITIONS === */
* {
    transition: background-color var(--transition-base),
                color var(--transition-base),
                border-color var(--transition-base),
                opacity var(--transition-base);
}

/* === CUSTOM SCROLLBAR === */
::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

::-webkit-scrollbar-track {
    background: var(--bg-input);
    border-radius: var(--radius-full);
}

::-webkit-scrollbar-thumb {
    background: var(--accent-primary);
    border-radius: var(--radius-full);
    border: 2px solid var(--bg-input);
}

::-webkit-scrollbar-thumb:hover {
    background: var(--accent-secondary);
}

/* === SELECTION COLORS === */
::selection {
    background: var(--accent-primary);
    color: #ffffff;
}

::-moz-selection {
    background: var(--accent-primary);
    color: #ffffff;
}
</style>