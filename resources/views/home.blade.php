@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    /*==============================================
    =            VARIABLES & RESET                  =
    ==============================================*/
    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --primary-light: rgba(16, 185, 129, 0.1);
        --primary-glow: rgba(16, 185, 129, 0.2);
        --dark: #0f172a;
        --dark-soft: #1e293b;
        --dark-card: rgba(30, 41, 59, 0.7);
        --gray: #64748b;
        --gray-light: #94a3b8;
        --border: rgba(255, 255, 255, 0.1);
        --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: var(--dark);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: white;
    }

    /*==============================================
    =            NOTIFICATION TOAST                 =
    ==============================================*/
    .notification-toast {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        max-width: 380px;
        width: calc(100% - 48px);
        animation: slideInRight 0.3s ease forwards;
        filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.2));
    }

    .notification-toast.hide {
        animation: slideOutRight 0.3s ease forwards;
    }

    .notification-content {
        position: relative;
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        color: white;
        overflow: hidden;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: var(--shadow-xl);
    }

    .notification-icon {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .notification-message {
        flex: 1;
    }

    .notification-title {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .notification-text {
        font-size: 14px;
        opacity: 0.9;
        line-height: 1.5;
    }

    .notification-close {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .notification-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .notification-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        width: 100%;
        animation: progress 4s linear forwards;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
    }

    /*==============================================
    =            CONTAINER & UTILITIES              =
    ==============================================*/
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .section {
        padding: 80px 0;
    }

    .section-sm {
        padding: 60px 0;
    }

    /*==============================================
    =            TYPOGRAPHY                         =
    ==============================================*/
    .eyebrow {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--primary);
        margin-bottom: 16px;
        display: inline-block;
    }

    .h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 700;
        line-height: 1.2;
        color: white;
        margin-bottom: 24px;
    }

    .h2 {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 700;
        line-height: 1.3;
        color: white;
        margin-bottom: 16px;
    }

    .h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
        margin-bottom: 12px;
    }

    .text-gradient {
        background: linear-gradient(135deg, var(--primary), #34d399);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .text-lead {
        font-size: 1.125rem;
        line-height: 1.7;
        color: var(--gray-light);
        margin-bottom: 24px;
    }

    .text-muted {
        color: var(--gray);
        font-size: 0.95rem;
    }

    /*==============================================
    =            BUTTONS                            =
    ==============================================*/
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: 0 10px 20px -10px var(--primary);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 30px -10px var(--primary);
    }

    .btn-outline {
        background: transparent;
        color: white;
        border: 1px solid var(--border);
    }

    .btn-outline:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-2px);
    }

    .btn-large {
        padding: 16px 40px;
        font-size: 1.125rem;
    }

    /*==============================================
    =            HERO SECTION                       =
    ==============================================*/
    .hero {
        position: relative;
        min-height: 650px;
        display: flex;
        align-items: center;
        border-radius: 40px;
        overflow: hidden;
        margin-bottom: 80px;
        background: linear-gradient(135deg, #030712, #111827);
        isolation: isolate;
    }

    .hero-pattern {
        position: absolute;
        inset: 0;
        background-image: 
            radial-gradient(circle at 20% 30%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
        z-index: 1;
    }

    .hero-glow {
        position: absolute;
        top: -50%;
        right: -20%;
        width: 80%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
        filter: blur(80px);
        z-index: 1;
        animation: glow 15s ease-in-out infinite;
    }

    @keyframes glow {
        0%, 100% { transform: translate(0, 0); opacity: 0.5; }
        50% { transform: translate(-30px, 30px); opacity: 0.8; }
    }

    .hero-content {
        position: relative;
        z-index: 10;
        padding: 60px 0;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    /* Hero Badge */
    .hero-badge-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 32px;
    }

    .hero-badge {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 10px 20px;
        border-radius: 60px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.9);
        position: relative;
        z-index: 2;
    }

    .hero-badge i {
        color: var(--primary);
    }

    .hero-badge-glow {
        position: absolute;
        inset: -2px;
        background: linear-gradient(90deg, var(--primary), #34d399, var(--primary));
        border-radius: 60px;
        filter: blur(8px);
        opacity: 0.3;
        z-index: 1;
        animation: badgeGlow 3s ease-in-out infinite;
    }

    @keyframes badgeGlow {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.6; }
    }

    /* Hero Title */
    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4.2rem);
        font-weight: 800;
        line-height: 1.2;
        color: white;
        margin-bottom: 24px;
    }

    .hero-description {
        font-size: 1.2rem;
        color: var(--gray-light);
        max-width: 550px;
        margin-bottom: 32px;
        line-height: 1.8;
    }

    .hero-highlight {
        display: inline-block;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 40px;
        padding: 10px 20px;
        color: var(--primary);
        font-size: 0.95rem;
        margin-bottom: 32px;
        backdrop-filter: blur(5px);
    }

    .hero-highlight i {
        margin-right: 8px;
    }

    /* Hero Stats */
    .hero-stats {
        display: flex;
        gap: 48px;
        margin-top: 48px;
        padding-top: 32px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .stat-item {
        text-align: left;
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Hero Cards */
    .hero-cards {
        position: relative;
        height: 500px;
    }

    .feature-card {
        position: absolute;
        width: 280px;
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 32px;
        padding: 28px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-xl);
    }

    .feature-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(16, 185, 129, 0.3);
        background: rgba(255, 255, 255, 0.03);
    }

    .card-1 {
        top: 0;
        right: 0;
        animation: float1 7s ease-in-out infinite;
    }

    .card-2 {
        top: 160px;
        left: 20px;
        animation: float2 7s ease-in-out infinite 0.5s;
    }

    .card-3 {
        bottom: 20px;
        right: 40px;
        animation: float3 7s ease-in-out infinite 1s;
    }

    @keyframes float1 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-15px, -15px); }
    }

    @keyframes float2 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(15px, -10px); }
    }

    @keyframes float3 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-10px, -20px); }
    }

    .card-icon {
        width: 60px;
        height: 60px;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        color: var(--primary);
        font-size: 24px;
        transition: all 0.3s ease;
    }

    .feature-card:hover .card-icon {
        background: var(--primary);
        color: white;
        transform: scale(1.1) rotate(5deg);
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
    }

    .card-text {
        color: var(--gray);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /*==============================================
    =            SECTION HEADER                     =
    ==============================================*/
    .section-header {
        text-align: center;
        margin-bottom: 48px;
    }
    
    .section-title {
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 700;
        color: white;
        margin-bottom: 16px;
    }
    
    .section-description {
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto;
        font-size: 1rem;
        line-height: 1.7;
    }

    /*==============================================
    =            CATEGORY CARDS                     =
    ==============================================*/
    .category-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
    }

    .category-card {
        background: var(--dark-card);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.1);
        border-radius: 24px;
        padding: 32px 20px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }

    .category-card:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
        background: rgba(30, 41, 59, 0.8);
    }

    .category-icon {
        width: 80px;
        height: 80px;
        background: rgba(16, 185, 129, 0.1);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--primary);
        font-size: 32px;
        transition: all 0.3s ease;
    }

    .category-card:hover .category-icon {
        background: var(--primary);
        color: white;
        transform: scale(1.1) rotate(5deg);
    }

    .category-name {
        color: white;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 1.1rem;
    }

    .category-count {
        color: var(--gray);
        font-size: 0.9rem;
    }

    /*==============================================
    =            PROMO BANNERS                      =
    ==============================================*/
    .promo-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .promo-card {
        border-radius: 32px;
        padding: 40px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .promo-card:hover {
        transform: scale(1.02);
    }

    .promo-card-1 {
        background: linear-gradient(135deg, #ea580c, #b91c1c);
    }

    .promo-card-2 {
        background: linear-gradient(135deg, #059669, #065f46);
    }

    .promo-tag {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 8px 16px;
        border-radius: 40px;
        font-size: 0.9rem;
        font-weight: 600;
        color: white;
        margin-bottom: 24px;
    }

    .promo-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: white;
        margin-bottom: 16px;
    }

    .promo-text {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 24px;
        font-size: 1rem;
        line-height: 1.6;
    }

    .promo-feature {
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
        margin-bottom: 28px;
    }

    .promo-feature i {
        font-size: 28px;
    }

    .btn-promo {
        background: white;
        color: #000;
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-promo:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.3);
    }

    /*==============================================
    =            PRODUCT SLIDER                     =
    ==============================================*/
    .section-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    .slider-controls {
        display: flex;
        gap: 12px;
    }

    .slider-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .slider-btn:hover:not(:disabled) {
        background: var(--primary);
        border-color: var(--primary);
        transform: scale(1.1);
    }

    .slider-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .slider-container {
        overflow: hidden;
        margin: 0 -10px;
    }

    .slider-track {
        display: flex;
        gap: 20px;
        transition: transform 0.3s ease;
        padding: 10px;
    }

    .product-card {
        flex: 0 0 calc(20% - 16px);
        min-width: 200px;
        background: var(--dark-card);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.1);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }

    .product-card:hover {
        transform: translateY(-5px);
        border-color: rgba(16, 185, 129, 0.3);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.5);
    }

    .product-image {
        aspect-ratio: 1;
        width: 100%;
        object-fit: cover;
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    .product-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: var(--primary);
        color: white;
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }

    .product-info {
        padding: 20px;
    }

    .product-category {
        font-size: 0.75rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .product-name {
        font-size: 1rem;
        font-weight: 600;
        color: white;
        margin-bottom: 8px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 16px;
    }

    .product-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .product-stock {
        font-size: 0.875rem;
        color: var(--gray);
    }

    .btn-add {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-add:hover {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
    }

    /*==============================================
    =            BENEFITS GRID                      =
    ==============================================*/
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .benefit-item {
        background: var(--dark-card);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.1);
        border-radius: 24px;
        padding: 32px 24px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .benefit-item:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
    }

    .benefit-icon {
        width: 64px;
        height: 64px;
        background: rgba(16, 185, 129, 0.1);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--primary);
        font-size: 28px;
        transition: all 0.3s ease;
    }

    .benefit-item:hover .benefit-icon {
        background: var(--primary);
        color: white;
        transform: scale(1.1) rotate(5deg);
    }

    .benefit-title {
        font-weight: 600;
        color: white;
        margin-bottom: 8px;
    }

    .benefit-desc {
        color: var(--gray);
        font-size: 0.9rem;
        line-height: 1.6;
    }

    /*==============================================
    =            TESTIMONIAL CARDS                  =
    ==============================================*/
    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .testimonial-card {
        background: var(--dark-card);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.1);
        border-radius: 24px;
        padding: 32px;
        transition: all 0.3s ease;
        position: relative;
    }

    .testimonial-card:hover {
        border-color: rgba(16, 185, 129, 0.3);
        transform: translateY(-5px);
    }

    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 5rem;
        color: rgba(16, 185, 129, 0.1);
        font-family: serif;
        line-height: 1;
    }

    .testimonial-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .testimonial-avatar {
        width: 56px;
        height: 56px;
        background: var(--primary);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 600;
        color: white;
    }

    .testimonial-name h4 {
        font-weight: 600;
        color: white;
        margin-bottom: 4px;
    }

    .testimonial-name p {
        font-size: 0.875rem;
        color: var(--gray);
    }

    .testimonial-rating {
        color: #fbbf24;
        margin-bottom: 16px;
    }

    .testimonial-text {
        color: var(--gray-light);
        font-style: italic;
        line-height: 1.7;
        font-size: 0.95rem;
    }

    /*==============================================
    =            CTA SECTION                        =
    ==============================================*/
    .cta-section {
        background: linear-gradient(135deg, #059669, #047857);
        border-radius: 40px;
        padding: 80px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 60%);
    }

    .cta-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        margin: 0 auto;
    }

    .cta-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 700;
        color: white;
        margin-bottom: 20px;
    }

    .cta-text {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.125rem;
        margin-bottom: 40px;
        line-height: 1.8;
    }

    .cta-buttons {
        display: flex;
        gap: 16px;
        justify-content: center;
    }

    .btn-cta-primary {
        background: white;
        color: #047857;
        padding: 16px 40px;
        border-radius: 40px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-cta-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.3);
    }

    .btn-cta-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        padding: 16px 40px;
        border-radius: 40px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-cta-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    /*==============================================
    =            RESPONSIVE                         =
    ==============================================*/
    @media (max-width: 1024px) {
        .hero-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .hero-cards {
            display: none;
        }

        .category-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .product-card {
            flex: 0 0 calc(25% - 15px);
        }

        .benefits-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .testimonials-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .promo-grid {
            grid-template-columns: 1fr;
        }

        .product-card {
            flex: 0 0 calc(50% - 10px);
        }

        .benefits-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .testimonials-grid {
            grid-template-columns: 1fr;
        }

        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }

        .section-header-flex {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .hero-stats {
            gap: 24px;
        }

        .stat-number {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 640px) {
        .product-card {
            flex: 0 0 100%;
        }

        .benefits-grid {
            grid-template-columns: 1fr;
        }

        .hero-stats {
            flex-direction: column;
            gap: 16px;
        }

        .hero-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .promo-card {
            padding: 30px;
        }

        .promo-title {
            font-size: 1.8rem;
        }
    }

    /* Utility Classes */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<!-- ===== HERO SECTION ===== -->
<section class="hero">
    <div class="hero-pattern"></div>
    <div class="hero-glow"></div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-grid">
                <!-- Left Column -->
                <div>
                    <div class="hero-badge-wrapper">
                        <div class="hero-badge">
                            <i class="fas fa-crown"></i>
                            <span>Official Store Since 2025</span>
                        </div>
                        <div class="hero-badge-glow"></div>
                    </div>
                    
                    <h1 class="hero-title">
                        Belanja Kebutuhan <span class="text-gradient">Rumah Tangga</span> 
                        Jadi Lebih Mudah
                    </h1>
                    
                    <p class="hero-description">
                        Dapatkan berbagai kebutuhan rumah tangga dengan harga terjangkau, 
                        kualitas terbaik, dan pengiriman cepat ke seluruh Indonesia.
                    </p>
                    
                    <div class="hero-highlight">
                        <i class="fas fa-truck"></i>
                        Gratis ongkir untuk area Jabodetabek!
                    </div>
                    
                    <div class="hero-actions" style="display: flex; gap: 16px; margin-bottom: 40px;">
                        <a href="{{ route('customer.products.index') }}" class="btn btn-primary btn-large">
                            <i class="fas fa-store"></i>
                            Belanja Sekarang
                        </a>
                        <a href="#categories" class="btn btn-outline btn-large">
                            <i class="fas fa-grid-2"></i>
                            Lihat Kategori
                        </a>
                    </div>
                    
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">50K+</div>
                            <div class="stat-label">Pelanggan Aktif</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Produk</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">100+</div>
                            <div class="stat-label">Kota</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Cards -->
                <div class="hero-cards">
                    <div class="feature-card card-1">
                        <div class="card-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h3 class="card-title">Gratis Ongkir</h3>
                        <p class="card-text">Minimal belanja Rp50.000 untuk area Jabodetabek</p>
                    </div>
                    
                    <div class="feature-card card-2">
                        <div class="card-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="card-title">Garansi 100%</h3>
                        <p class="card-text">Barang original & berkualitas, garansi uang kembali</p>
                    </div>
                    
                    <div class="feature-card card-3">
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="card-title">24/7 Support</h3>
                        <p class="card-text">Customer service siap membantu kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CATEGORIES SECTION ===== -->
<section id="categories" class="section">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Kategori Produk</span>
            <h2 class="section-title">Pilih Kebutuhan Anda</h2>
            <p class="section-description">
                Temukan berbagai kategori produk berkualitas untuk kebutuhan rumah tangga Anda
            </p>
        </div>
        
        <div class="category-grid">
            @php
                $categories = [
                    ['icon' => 'fa-utensils', 'name' => 'Sembako', 'count' => '1.2K'],
                    ['icon' => 'fa-wine-bottle', 'name' => 'Minuman', 'count' => '850'],
                    ['icon' => 'fa-cookie', 'name' => 'Snack', 'count' => '2K'],
                    ['icon' => 'fa-soap', 'name' => 'Perlengkapan Mandi', 'count' => '600'],
                    ['icon' => 'fa-broom', 'name' => 'Alat Rumah Tangga', 'count' => '450'],
                ];
            @endphp
            
            @foreach($categories as $cat)
            <a href="{{ route('customer.products.index', ['category' => $loop->index + 1]) }}" class="category-card">
                <div class="category-icon">
                    <i class="fas {{ $cat['icon'] }}"></i>
                </div>
                <h3 class="category-name">{{ $cat['name'] }}</h3>
                <p class="category-count">{{ $cat['count'] }} produk</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== PROMO BANNERS ===== -->
<section class="section-sm">
    <div class="container">
        <div class="promo-grid">
            <!-- Banner 1 -->
            <div class="promo-card promo-card-1">
                <span class="promo-tag">🔥 Flash Sale</span>
                <h3 class="promo-title">Diskon 50%</h3>
                <p class="promo-text">Untuk produk sembako terpilih</p>
                <div class="promo-feature">
                    <i class="fas fa-clock"></i>
                    <span>Berakhir dalam 24 jam</span>
                </div>
                <a href="{{ route('customer.products.index') }}" class="btn-promo">
                    Beli Sekarang
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <!-- Banner 2 -->
            <div class="promo-card promo-card-2">
                <span class="promo-tag">🚚 Promo Spesial</span>
                <h3 class="promo-title">Beli 2 Gratis 1</h3>
                <p class="promo-text">Untuk produk minuman tertentu</p>
                <div class="promo-feature">
                    <i class="fas fa-truck"></i>
                    <span>Min. belanja Rp100.000</span>
                </div>
                <a href="{{ route('customer.products.index') }}" class="btn-promo">
                    Lihat Promo
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== RECOMMENDED PRODUCTS ===== -->
<section class="section">
    <div class="container">
        <div class="section-header-flex">
            <div>
                <span class="eyebrow">Rekomendasi</span>
                <h2 class="h2">Produk Terbaru</h2>
            </div>
            <div style="display: flex; align-items: center; gap: 20px;">
                <a href="{{ route('customer.products.index') }}" class="btn-link" style="color: var(--gray); text-decoration: none;">
                    Lihat Semua
                    <i class="fas fa-arrow-right"></i>
                </a>
                <div class="slider-controls">
                    <button id="prevBtn" class="slider-btn">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="nextBtn" class="slider-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="slider-container">
            <div id="productSlider" class="slider-track">
                @forelse($featuredProducts as $product)
                <div class="product-card">
                    <a href="{{ route('customer.products.show', $product->slug) }}" style="text-decoration: none; color: inherit; display: block;">
                        <div class="product-image" style="position: relative;">
                            @php
                                $imageUrl = null;
                                $imageExists = false;
                                
                                if ($product->image) {
                                    $paths = [
                                        'storage/' . $product->image,
                                        'product-images/' . $product->image,
                                        'uploads/products/' . $product->image,
                                        $product->image
                                    ];
                                    
                                    foreach ($paths as $path) {
                                        if (file_exists(public_path($path))) {
                                            $imageExists = true;
                                            $imageUrl = asset($path);
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            
                            @if($imageExists)
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-box-open text-3xl text-white/30"></i>
                                </div>
                            @endif
                            
                            @if($product->created_at->diffInDays(now()) < 7)
                                <span class="product-badge">NEW</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <span class="product-category">{{ $product->category->name ?? 'Kategori' }}</span>
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="product-footer">
                                <span class="product-stock">Stok: {{ $product->stock }}</span>
                                @auth
                                <button onclick="addToCart({{ $product->id }}, event)" class="btn-add">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                @else
                                <a href="{{ route('login') }}" class="btn-add" style="color: #3b82f6;" onclick="event.stopPropagation()">
                                    <i class="fas fa-sign-in-alt"></i>
                                </a>
                                @endauth
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                @for($i = 1; $i <= 5; $i++)
                <div class="product-card">
                    <div class="product-image" style="display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-box-open text-3xl text-white/30"></i>
                    </div>
                    <div class="product-info">
                        <span class="product-category">Kategori</span>
                        <h3 class="product-name">Produk Unggulan {{ $i }}</h3>
                        <div class="product-price">Rp 25.000</div>
                        <div class="product-footer">
                            <span class="product-stock">Stok: 50</span>
                            <button class="btn-add">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>
        </div>
        
        <!-- Mobile View All -->
        <div style="text-align: center; margin-top: 40px; display: none;" class="mobile-view">
            <a href="{{ route('customer.products.index') }}" class="btn btn-outline">
                Lihat Semua Produk
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- ===== BENEFITS SECTION ===== -->
<section class="section-sm">
    <div class="container">
        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h4 class="benefit-title">Gratis Ongkir</h4>
                <p class="benefit-desc">Min. belanja Rp50rb</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="benefit-title">Garansi 100%</h4>
                <p class="benefit-desc">Barang original</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4 class="benefit-title">24/7 Support</h4>
                <p class="benefit-desc">CS siap membantu</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h4 class="benefit-title">Pembayaran</h4>
                <p class="benefit-desc">Transfer & COD</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== TESTIMONIALS SECTION ===== -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Testimonial</span>
            <h2 class="section-title">Apa Kata Pelanggan</h2>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">A</div>
                    <div class="testimonial-name">
                        <h4>Ahmad Fauzi</h4>
                        <p>Pemilik Warung</p>
                    </div>
                </div>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "Barang selalu lengkap, pengiriman cepat, dan harganya bersaing. Sangat membantu untuk stok warung saya."
                </p>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">S</div>
                    <div class="testimonial-name">
                        <h4>Siti Nurhaliza</h4>
                        <p>Ibu Rumah Tangga</p>
                    </div>
                </div>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="testimonial-text">
                    "Belanja jadi lebih praktis, tidak perlu keluar rumah. Barang sampai dengan aman dan rapi."
                </p>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">R</div>
                    <div class="testimonial-name">
                        <h4>Rudi Hermawan</h4>
                        <p>Pengusaha Catering</p>
                    </div>
                </div>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "Harga grosirnya sangat kompetitif. Sangat cocok untuk usaha catering seperti saya."
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ===== CTA SECTION ===== -->
<section class="section">
    <div class="container">
        <div class="cta-section">
            <div class="cta-content">
                <h2 class="cta-title">Siap untuk Belanja?</h2>
                <p class="cta-text">
                    Daftar sekarang dan dapatkan promo spesial untuk pembelian pertama Anda!
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn-cta-primary">
                        <i class="fas fa-user-plus"></i>
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('customer.products.index') }}" class="btn-cta-secondary">
                        <i class="fas fa-store"></i>
                        Mulai Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Slider functionality
        const slider = document.getElementById('productSlider');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const slides = document.querySelectorAll('.product-card');
        
        if (!slider || !prevBtn || !nextBtn || slides.length === 0) return;
        
        let currentIndex = 0;
        
        function getVisibleSlides() {
            const width = window.innerWidth;
            if (width >= 1024) return 5;
            if (width >= 768) return 3;
            if (width >= 640) return 2;
            return 1;
        }
        
        function getSlideWidth() {
            if (slides.length === 0) return 0;
            const slide = slides[0];
            const width = slide.offsetWidth;
            const gap = 20;
            return width + gap;
        }
        
        let visibleSlides = getVisibleSlides();
        let slideWidth = getSlideWidth();
        const maxIndex = Math.max(0, slides.length - visibleSlides);
        
        function updateSlider() {
            slideWidth = getSlideWidth();
            const translateX = currentIndex * slideWidth;
            slider.style.transform = `translateX(-${translateX}px)`;
            
            if (prevBtn) prevBtn.disabled = currentIndex === 0;
            if (nextBtn) nextBtn.disabled = currentIndex >= maxIndex;
        }
        
        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        });
        
        nextBtn.addEventListener('click', () => {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateSlider();
            }
        });
        
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                visibleSlides = getVisibleSlides();
                slideWidth = getSlideWidth();
                const newMaxIndex = Math.max(0, slides.length - visibleSlides);
                if (currentIndex > newMaxIndex) {
                    currentIndex = newMaxIndex;
                }
                updateSlider();
            }, 250);
        });
        
        updateSlider();
        
        // Mobile view all button
        if (window.innerWidth <= 768) {
            document.querySelector('.mobile-view').style.display = 'block';
        }
    });

    // Add to cart function
    function addToCart(productId, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        const button = event.currentTarget;
        const originalHtml = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        fetch('{{ route("customer.cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartBadges = document.querySelectorAll('.cart-badge');
                cartBadges.forEach(badge => {
                    badge.textContent = data.cart_count;
                    badge.classList.add('animate-ping');
                    setTimeout(() => badge.classList.remove('animate-ping'), 500);
                });
                
                showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
                
                button.innerHTML = originalHtml;
                button.disabled = false;
            } else {
                showNotification(data.message, 'error');
                button.innerHTML = originalHtml;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
            button.innerHTML = originalHtml;
            button.disabled = false;
        });
    }
    
    function showNotification(message, type = 'success') {
        const existing = document.querySelector('.notification-toast');
        if (existing) existing.remove();
        
        const notification = document.createElement('div');
        notification.className = 'notification-toast';
        
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const bgColor = type === 'success' ? 'linear-gradient(135deg, #10b981, #047857)' : 'linear-gradient(135deg, #ef4444, #b91c1c)';
        
        notification.innerHTML = `
            <div class="notification-content" style="background: ${bgColor};">
                <div class="notification-icon"><i class="fas ${icon}"></i></div>
                <div class="notification-message">
                    <div class="notification-title">${type === 'success' ? 'Berhasil!' : 'Gagal!'}</div>
                    <div class="notification-text">${message}</div>
                </div>
                <button class="notification-close" onclick="this.closest('.notification-toast').remove()"><i class="fas fa-times"></i></button>
                <div class="notification-progress"></div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification && notification.parentElement) {
                notification.classList.add('hide');
                setTimeout(() => notification.remove(), 500);
            }
        }, 4000);
    }
</script>
@endpush