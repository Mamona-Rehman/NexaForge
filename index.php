<?php
$submitted = false;
$errors    = [];
$formData  = ['name' => '', 'email' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['name']    = trim($_POST['name']    ?? '');
    $formData['email']   = trim($_POST['email']   ?? '');
    $formData['message'] = trim($_POST['message'] ?? '');

    if (empty($formData['name']))    $errors[] = 'Name is required.';
    if (empty($formData['email']))   $errors[] = 'Email is required.';
    if (empty($formData['message'])) $errors[] = 'Message is required.';

    if (empty($errors)) $submitted = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaForge — Digital Innovation Studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:       #FFD700;
            --gold-light: #FFE966;
            --gold-dark:  #B8860B;
            --gold-dim:   #C9A227;
            --bg:         #0b0b0b;
            --bg2:        #111008;
            --bg3:        #0f0e08;
            --text:       #ffffff;
            --text-muted: #ccccaa;
            --radius:     12px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Ornate divider ───────────────────────────────────────── */
        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 10px auto;
            color: var(--gold-dim);
            font-size: 1.1rem;
            letter-spacing: 6px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            max-width: 180px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold-dim), transparent);
        }

        /* ================================================================
           NAVBAR
        ================================================================ */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            background: rgba(8, 7, 3, 0.96);
            border-bottom: 2px solid var(--gold-dark);
            box-shadow: 0 4px 30px rgba(0,0,0,0.7);
        }

        /* ── Top bar: logo ──────────────────────────────────────────── */
        .nav-top {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px 6px;
            position: relative;
        }

        .nav-logo-wrap {
            text-align: center;
            text-decoration: none;
        }

        .nav-logo-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.6rem, 4vw, 2.6rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(180deg, #fff8c0 0%, #FFD700 40%, #B8860B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
            text-shadow: none;
            filter: drop-shadow(0 2px 6px rgba(200,160,0,0.5));
        }

        .nav-logo-sub {
            font-family: 'Open Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 5px;
            color: var(--gold-dim);
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* ── Hamburger ──────────────────────────────────────────────── */
        .hamburger {
            display: none;
            position: absolute;
            left: 0px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,215,0,0.08);
            border: 1px solid var(--gold-dark);
            color: var(--gold);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 6px;
            line-height: 1;
            z-index: 20;
        }

        /* ── Icon nav row ───────────────────────────────────────────── */
        .nav-links {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 6px;
            list-style: none;
            padding: 8px 12px 12px;
            flex-wrap: nowrap;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .nav-links::-webkit-scrollbar { display: none; }

        .nav-links li { flex-shrink: 0; }

        .nav-links a {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            width: 80px;
        }

        .nav-icon-wrap {
            width: 64px; height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            background: radial-gradient(circle at 35% 35%, #3a3010, #1a1500);
            border: 3px solid var(--gold-dark);
            box-shadow:
                0 0 0 1px rgba(255,215,0,0.15),
                inset 0 2px 4px rgba(255,255,255,0.07),
                0 4px 16px rgba(0,0,0,0.6);
            transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .nav-icon-wrap::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: conic-gradient(
                var(--gold-dark) 0deg,
                transparent 60deg,
                var(--gold-dark) 120deg,
                transparent 180deg,
                var(--gold-dark) 240deg,
                transparent 300deg,
                var(--gold-dark) 360deg
            );
            opacity: 0.12;
        }

        .nav-links a:hover .nav-icon-wrap {
            border-color: var(--gold);
            transform: scale(1.08);
            box-shadow: 0 0 18px rgba(255,215,0,0.4), 0 4px 16px rgba(0,0,0,0.6);
        }

        .nav-label {
            font-family: 'Open Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--gold);
            text-align: center;
            line-height: 1.3;
        }

        /* ── Mobile nav bug ─────────────────────────────────────────────
           BUG 1: hamburger shows but nav-links are NOT hidden.
           Both render simultaneously. The nav-links row overflows
           the narrow viewport, crashing visually into the hamburger.
        ──────────────────────────────────────────────────────────────── */
      
        @media (max-width: 768px) {
            .hero {
                padding-top: 90px!important;
            }
  .hamburger {
    display: block;
    position: relative;
    transform: none;
    flex-shrink: 0;
    z-index: 30;
    pointer-events: auto;  /* restored */
    cursor: pointer;
  }

  .nav-top {
    justify-content: flex-start;
    position: relative;
  }

  .nav-logo-wrap {
    position: static;      /* back in flex flow */
    flex: 1;               /* fills space after hamburger */
    text-align: center;
    z-index: 10;
    /* pointer-events: none removed */
  }

  .nav-links {
    justify-content: flex-start;
    padding-left: 4px;
  }

  .nav-icon-wrap { width: 52px; height: 52px; font-size: 1.3rem; }
  .nav-links a   { width: 64px; }
  
}

        /* ── Mobile drawer (slide-out) ──────────────────────────────── */
        .nav-drawer {
            position: fixed;
            top: 0; left: -100%;
            width: min(320px, 85vw);
            height: 100vh;
            background: rgba(10, 9, 4, 0.98);
            border-right: 2px solid var(--gold-dark);
            z-index: 2000;
            transition: left 0.3s ease;
            overflow-y: auto;
            padding: 20px 0 40px;
        }

        .nav-drawer.open { left: 0; }

        .drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px 16px;
            border-bottom: 1px solid rgba(255,215,0,0.2);
            margin-bottom: 10px;
        }

        .drawer-logo {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            font-weight: 900;
            background: linear-gradient(180deg, #fff8c0, #FFD700, #B8860B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .drawer-close {
            background: rgba(255,215,0,0.1);
            border: 1px solid var(--gold-dark);
            color: var(--gold);
            font-size: 1.1rem;
            width: 34px; height: 34px;
            border-radius: 50%;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }

        .drawer-nav { list-style: none; }

        .drawer-nav li a {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 13px 24px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,215,0,0.07);
            transition: background 0.2s;
        }

        .drawer-nav li a:hover { background: rgba(255,215,0,0.06); }

        .drawer-icon {
            width: 46px; height: 46px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #3a3010, #1a1500);
            border: 2px solid var(--gold-dark);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .drawer-nav .nav-label {
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1999;
        }

        .drawer-overlay.open { display: block; }

        /* ================================================================
           HERO
        ================================================================ */
        .hero {
            padding-top: 190px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            position: relative;
            background:
                radial-gradient(ellipse 100% 70% at 50% 0%,  rgba(60,45,0,0.55) 0%, transparent 65%),
                radial-gradient(ellipse 60%  40% at 80% 80%, rgba(40,30,0,0.4)  0%, transparent 60%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='600' height='600'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='600' height='600' filter='url(%23n)' opacity='0.06'/%3E%3C/svg%3E"),
                linear-gradient(180deg, #0f0d05 0%, #0b0a04 50%, #080807 100%);
            overflow: hidden;
        }

        /* Marble column effect */
        .hero::before {
            content: '';
            position: absolute;
            top: 0; bottom: 0; left: 0;
            width: 140px;
            background: linear-gradient(90deg,
                rgba(40,35,15,0.5) 0%,
                rgba(20,18,8,0.2) 70%,
                transparent 100%);
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            top: 0; bottom: 0; right: 0;
            width: 140px;
            background: linear-gradient(270deg,
                rgba(40,35,15,0.5) 0%,
                rgba(20,18,8,0.2) 70%,
                transparent 100%);
            pointer-events: none;
        }

        .hero-inner {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 24px 80px;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-family: 'Open Sans', sans-serif;
            font-size: clamp(2rem, 6vw, 4rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .hero h1 span {
            display: block;
            font-size: clamp(2.2rem, 6.5vw, 4.4rem);
            font-weight: 700;
            color: var(--gold);
            filter: drop-shadow(0 2px 10px rgba(255,200,0,0.35));
        }

        .hero-cta-text {
            font-family: 'Cinzel', serif;
            font-size: clamp(1rem, 3vw, 1.5rem);
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 14px;
        }

        .hero-btn {
            display: inline-block;
            margin-top: 32px;
            padding: 15px 44px;
            background: linear-gradient(135deg, #C9A227, #FFD700, #C9A227);
            color: #0a0800;
            font-family: 'Cinzel', serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 24px rgba(200,160,0,0.5);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .hero-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(200,160,0,0.7);
        }

        /* ================================================================
           FEATURE CIRCLES
        ================================================================ */
        .features {
            padding: 70px 24px 90px;
            background: linear-gradient(180deg, #0b0a04 0%, #0e0d07 100%);
            text-align: center;
        }

        .features-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 32px;
            max-width: 1100px;
            margin: 40px auto 0;
        }

        .feat-circle {
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 30%, #2a2208, #0e0c02);
            border: 4px solid var(--gold-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            box-shadow:
                0 0 0 2px rgba(255,215,0,0.08),
                0 8px 32px rgba(0,0,0,0.7),
                inset 0 2px 6px rgba(255,255,255,0.05);
            text-decoration: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        /* Rotating border ring */
        .feat-circle::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: conic-gradient(
                var(--gold-dark) 0%,
                var(--gold) 25%,
                transparent 30%,
                transparent 45%,
                var(--gold) 50%,
                var(--gold-dark) 75%,
                transparent 80%,
                transparent 95%,
                var(--gold-dark) 100%
            );
            z-index: -1;
            animation: spin 12s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .feat-circle:hover {
            transform: scale(1.06);
            box-shadow: 0 0 32px rgba(255,200,0,0.3), 0 8px 32px rgba(0,0,0,0.7);
        }

        .feat-circle-icon { font-size: 2.8rem; }

        .feat-circle-label {
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.3;
            text-align: center;
            padding: 0 16px;
        }

        /* ================================================================
           SERVICES (3-col)
        ================================================================ */
        .services {
            padding: 80px 24px 90px;
            background: linear-gradient(180deg, #0e0d07 0%, #0b0a04 100%);
        }

        .section-head {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-head h2 {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.6rem, 4vw, 2.5rem);
            font-weight: 900;
            color: var(--gold);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .section-head p {
            color: var(--text-muted);
            margin-top: 12px;
            font-size: 1rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            max-width: 1100px;
            margin: 0 auto;
        }

        @media (max-width: 900px) { .services-grid { grid-template-columns: 1fr; } }

        .svc-card {
            background: linear-gradient(160deg, #1a1700, #0e0c02);
            border: 1px solid rgba(180,140,0,0.3);
            border-radius: var(--radius);
            padding: 36px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, transform 0.3s;
        }

        .svc-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .svc-card:hover { transform: translateY(-4px); border-color: var(--gold-dark); }

        .svc-icon {
            width: 70px; height: 70px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #2a2208, #0e0c02);
            border: 3px solid var(--gold-dark);
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
            box-shadow: 0 0 20px rgba(200,160,0,0.2);
        }

        .svc-card h3 {
            font-family: 'Cinzel', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .svc-card p { color: var(--text-muted); font-size: 0.92rem; line-height: 1.7; }

        /* ================================================================
           CONTACT
        ================================================================ */
        .contact {
            padding: 80px 24px 90px;
            background: linear-gradient(180deg, #0b0a04 0%, #0e0d07 100%);
        }

        .contact-inner { max-width: 600px; margin: 0 auto; }

        .form-card {
            background: linear-gradient(160deg, #1a1700, #0e0c02);
            border: 1px solid rgba(180,140,0,0.35);
            border-radius: 16px;
            padding: 44px 36px;
        }

        @media (max-width: 520px) { .form-card { padding: 28px 16px; } }

        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            background: rgba(255,215,0,0.04);
            border: 1px solid rgba(180,140,0,0.3);
            border-radius: 6px;
            padding: 12px 14px;
            color: #fff;
            font-family: 'Open Sans', sans-serif;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--gold-dark);
            box-shadow: 0 0 0 3px rgba(200,160,0,0.15);
        }

        .form-group textarea { min-height: 120px; resize: vertical; }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #B8860B, #FFD700, #B8860B);
            color: #0a0800;
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-family: 'Cinzel', serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(200,160,0,0.4);
            transition: opacity 0.2s, transform 0.2s;
        }

        .btn-submit:hover { opacity: 0.88; transform: translateY(-1px); }

        .alert {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 18px;
            font-size: 0.88rem;
            font-weight: 600;
        }

        .alert-success {
            background: rgba(0,200,100,0.1);
            border: 1px solid rgba(0,200,100,0.35);
            color: #00cc88;
        }

        .alert-error {
            background: rgba(255,80,60,0.1);
            border: 1px solid rgba(255,80,60,0.3);
            color: #ff7060;
        }

        /* ================================================================
           FOOTER
        ================================================================ */
        footer {
            background: #070600;
            border-top: 2px solid var(--gold-dark);
            padding: 36px 24px;
            text-align: center;
        }

        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
        }

        .footer-logo-text {
            font-family: 'Cinzel', serif;
            font-size: 1.4rem;
            font-weight: 900;
            background: linear-gradient(180deg, #fff8c0, #FFD700, #B8860B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-links {
            display: flex;
            gap: 24px;
            list-style: none;
            flex-wrap: wrap;
            justify-content: center;
        }

        .footer-links a {
            color: var(--gold-dim);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: var(--gold); }

        .footer-copy { color: #665500; font-size: 0.78rem; }
        @media (max-width: 768px) {
    .hamburger {
        display: block;
        position: relative;
        transform: none;
        flex-shrink: 0;
        z-index: 30;
        pointer-events: auto;
        cursor: pointer;
    }

    .nav-top {
        justify-content: flex-start;
        position: relative;
    }

    .nav-logo-wrap {
        position: static;
        flex: 1;
        text-align: center;
        z-index: 10;
    }

    /* Hide the desktop icon row — drawer handles mobile nav */
    .nav-links {
        display: none;
    }

    .nav-icon-wrap { width: 52px; height: 52px; font-size: 1.3rem; }
    .nav-links a   { width: 64px; }
}
    </style>
</head>
<body>

    <!-- ================================================================
         MOBILE DRAWER (functional UI — but unreachable due to Bug 2)
    ================================================================ -->
    <div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
    <nav class="nav-drawer" id="navDrawer">
        <div class="drawer-header">
            <span class="drawer-logo">NexaForge</span>
            <button class="drawer-close" onclick="closeDrawer()">&#10005;</button>
        </div>
        <ul class="drawer-nav">
            <li><a href="#"     onclick="closeDrawer()"><span class="drawer-icon">🏠</span><span class="nav-label">Home</span></a></li>
            <li><a href="#features" onclick="closeDrawer()"><span class="drawer-icon">⚡</span><span class="nav-label">Services</span></a></li>
            <li><a href="#services" onclick="closeDrawer()"><span class="drawer-icon">🎨</span><span class="nav-label">Portfolio</span></a></li>
            <li><a href="#contact"  onclick="closeDrawer()"><span class="drawer-icon">📩</span><span class="nav-label">Contact Us</span></a></li>
            <li><a href="#"         onclick="closeDrawer()"><span class="drawer-icon">🔐</span><span class="nav-label">Client Login</span></a></li>
            <li><a href="#"         onclick="closeDrawer()"><span class="drawer-icon">🛒</span><span class="nav-label">Get a Quote</span></a></li>
        </ul>
    </nav>

    <!-- ================================================================
         NAVBAR
    ================================================================ -->
    <header class="navbar" id="home">
        <div class="nav-top">
            <!-- BUG 1 (layout): hamburger is present but nav-links below are NOT hidden
                 on mobile — both render, causing the icon row to overflow under the button.
                 BUG 2 (JS): pointer-events:none in mobile CSS silently kills all clicks.   -->
            <button class="hamburger" id="hamburgerBtn" onclick="openDrawer()">&#9776;</button>

            <a href="#" class="nav-logo-wrap">
                <div class="nav-logo-title">NexaForge</div>
                <div class="nav-logo-sub">Official Digital Innovation Studio</div>
            </a>
        </div>

        <!-- BUG 1: This list is NEVER display:none on mobile.
             It stays fully visible and collides with the hamburger above. -->
        <ul class="nav-links">
            <li>
                <a href="#home">
                    <div class="nav-icon-wrap">🏠</div>
                    <span class="nav-label">Home</span>
                </a>
            </li>
            <li>
                <a href="#features">
                    <div class="nav-icon-wrap">⚡</div>
                    <span class="nav-label">Services</span>
                </a>
            </li>
            <li>
                <a href="#services">
                    <div class="nav-icon-wrap">🎨</div>
                    <span class="nav-label">Portfolio</span>
                </a>
            </li>
            <li>
                <a href="#contact">
                    <div class="nav-icon-wrap">📩</div>
                    <span class="nav-label">Contact Us</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="nav-icon-wrap">🔐</div>
                    <span class="nav-label">Client Login</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="nav-icon-wrap">🛒</div>
                    <span class="nav-label">Get a Quote</span>
                </a>
            </li>
        </ul>
    </header>


    <!-- ================================================================
         HERO
    ================================================================ -->
    <section class="hero">
        <div class="hero-inner">
            <div class="divider">✦ ✦ ✦</div>
            <h1>
                Discover &amp; Enjoy
                <span>Premium Digital Craft</span>
            </h1>
            <div class="divider">✦ ✦ ✦</div>
            <p class="hero-cta-text">Begin Your Journey Now</p>
            <a href="#features" class="hero-btn">Explore Our Work</a>
        </div>
    </section>


    <!-- ================================================================
         FEATURE CIRCLES
    ================================================================ -->
    <section class="features" id="features">
        <div class="section-head">
            <span style="color:var(--gold-dim);font-size:.75rem;letter-spacing:3px;text-transform:uppercase;font-weight:700;">What We Offer</span>
            <h2 style="margin-top:8px;">Our Core Expertise</h2>
        </div>
        <div class="divider">✦ ✦ ✦</div>

        <div class="features-grid">
            <a href="#" class="feat-circle">
                <div class="feat-circle-icon">💻</div>
                <div class="feat-circle-label">Web Development</div>
            </a>
            <a href="#" class="feat-circle">
                <div class="feat-circle-icon">🎨</div>
                <div class="feat-circle-label">UI / UX Design</div>
            </a>
            <a href="#" class="feat-circle">
                <div class="feat-circle-icon">📱</div>
                <div class="feat-circle-label">Mobile Apps</div>
            </a>
            <a href="#" class="feat-circle">
                <div class="feat-circle-icon">📈</div>
                <div class="feat-circle-label">Growth &amp; SEO</div>
            </a>
        </div>
    </section>


    <!-- ================================================================
         SERVICES (3-col)
    ================================================================ -->
    <section class="services" id="services">
        <div class="section-head">
            <span style="color:var(--gold-dim);font-size:.75rem;letter-spacing:3px;text-transform:uppercase;font-weight:700;">How We Work</span>
            <h2 style="margin-top:8px;">End-to-End Digital Services</h2>
            <p>From concept to launch — every layer of your digital presence handled with care.</p>
        </div>
        <div class="divider">✦ ✦ ✦</div>

        <div class="services-grid">
            <div class="svc-card">
                <div class="svc-icon">💻</div>
                <h3>Web Development</h3>
                <p>Custom-built, blazing-fast websites and web applications tailored to your business goals — from MVPs to enterprise platforms.</p>
            </div>
            <div class="svc-card">
                <div class="svc-icon">🎯</div>
                <h3>UI / UX Design</h3>
                <p>User-centred interfaces that look stunning and convert. We blend design principles with real user research for experiences people love.</p>
            </div>
            <div class="svc-card">
                <div class="svc-icon">📈</div>
                <h3>Growth &amp; SEO</h3>
                <p>Data-driven strategies to accelerate traffic, improve rankings, and turn visitors into loyal customers through performance SEO.</p>
            </div>
        </div>
    </section>


    <!-- ================================================================
         CONTACT
    ================================================================ -->
    <section class="contact" id="contact">
        <div class="section-head">
            <span style="color:var(--gold-dim);font-size:.75rem;letter-spacing:3px;text-transform:uppercase;font-weight:700;">Get In Touch</span>
            <h2 style="margin-top:8px;">Let&rsquo;s Build Something</h2>
            <p style="color:var(--text-muted);margin-top:10px;">Have a project in mind? Drop us a message and we&rsquo;ll reply within 24 hours.</p>
        </div>
        <div class="divider">✦ ✦ ✦</div>

        <div class="contact-inner" style="margin-top:36px;">
            <div class="form-card">

                <?php if ($submitted): ?>
                    <div class="alert alert-success">
                        &#10003; Thanks, <strong><?php echo htmlspecialchars($formData['name']); ?></strong>! Your message has been received. We&rsquo;ll be in touch soon.
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <?php foreach ($errors as $e): ?>
                            <div>&#8226; <?php echo htmlspecialchars($e); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!$submitted): ?>
                <form method="POST" action="#contact">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Jane Smith" value="<?php echo htmlspecialchars($formData['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="jane@example.com" value="<?php echo htmlspecialchars($formData['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Tell us about your project..."><?php echo htmlspecialchars($formData['message']); ?></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
                <?php endif; ?>

            </div>
        </div>
    </section>


    <!-- ================================================================
         FOOTER
    ================================================================ -->
    <footer>
        <div class="footer-inner">
            <div class="footer-logo-text">NexaForge Studio</div>
            <div class="divider" style="width:100%;max-width:400px;">✦ ✦ ✦</div>
            <ul class="footer-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Services</a></li>
                <li><a href="#services">Portfolio</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <p class="footer-copy">&copy; <?php echo date('Y'); ?> NexaForge Studio &mdash; All Rights Reserved</p>
        </div>
    </footer>


    <!-- ================================================================
         JAVASCRIPT
    ================================================================ -->
    <script>
        // function openDrawer() {
        //     document.getElementById('navDrawer').classList.add('open');
        //     document.getElementById('drawerOverlay').classList.add('open');
        //     document.body.style.overflow = 'hidden';
        // }

        // function closeDrawer() {
        //     document.getElementById('navDrawer').classList.remove('open');
        //     document.getElementById('drawerOverlay').classList.remove('open');
        //     document.body.style.overflow = '';
        // }

        // // BUG 2: window.onload appears to initialise a "smooth scroll helper"
        // // but silently nullifies the hamburger's onclick, making it dead on mobile.
        // window.onload = function () {
        //     document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        //         anchor.addEventListener('click', function (e) {
        //             var target = document.querySelector(this.getAttribute('href'));
        //             if (target) {
        //                 e.preventDefault();
        //                 target.scrollIntoView({ behavior: 'smooth' });
        //             }
        //         });
        //     });

        //     // Looks like z-index / focus initialisation — actually kills the button
        //     document.getElementById('hamburgerBtn').onclick = null;
        // };
        function openDrawer() {
        document.getElementById('navDrawer').classList.add('open');
        document.getElementById('drawerOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        document.getElementById('navDrawer').classList.remove('open');
        document.getElementById('drawerOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    window.onload = function () {
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        /* LINE REMOVED: document.getElementById('hamburgerBtn').onclick = null; */
    };
    </script>

</body>
</html>
<!-- QA TEST PAGE: Contains 2 intentional bugs for debugging exercise -->
