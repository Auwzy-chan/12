<?php
require_once __DIR__ . '/auth.php';
handleLogout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Hub - Premium Automotive Experience</title>
    <link rel="stylesheet" href="assets/site.css">
    <style>
        body {
            padding-top: 0;
        }

        main {
            padding: 110px 6% 50px;
            max-width: 1320px;
            margin: 0 auto;
        }

        .landing-hero {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 24px;
            align-items: stretch;
            margin-bottom: 28px;
        }

        .hero-card,
        .side-card,
        .feature-card {
            padding: 28px;
            backdrop-filter: blur(18px);
        }

        .hero-card {
            background: linear-gradient(135deg, rgba(255, 159, 5, 0.2), rgba(16, 24, 39, 0.95));
            min-height: 360px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .hero-card::after {
            content: '';
            position: absolute;
            inset: auto -20px -50px auto;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(255, 159, 5, 0.24), transparent 70%);
            pointer-events: none;
        }

        .eyebrow {
            color: var(--site-accent);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .hero-card h1 {
            font-size: clamp(2rem, 4vw, 3.15rem);
            line-height: 1.05;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: -0.03em;
        }

        .hero-card p {
            color: var(--site-muted);
            max-width: 620px;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--site-accent), #ffb347);
            color: #090909;
            box-shadow: 0 8px 20px rgba(255, 159, 5, 0.18);
        }

        .btn-secondary {
            color: var(--site-text);
            border: 1px solid var(--site-border);
            background: rgba(255,255,255,0.04);
        }

        .side-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 16px;
            background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
        }

        .side-card h3 {
            font-size: 1.15rem;
            margin-bottom: 4px;
        }

        .side-card p {
            color: var(--site-muted);
            line-height: 1.6;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .feature-card {
            min-height: 190px;
            background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
        }

        .feature-card h4 {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: var(--site-muted);
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .feature-card a {
            display: inline-block;
            margin-top: 14px;
            color: var(--site-accent);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 980px) {
            .landing-hero,
            .feature-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="brand">
            <div class="brand-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
            </div>
            <div class="brand-name">Auto Hub</div>
        </div>
        <nav>
            <a href="index.php" class="active">Home</a>
            <a href="Inventory.php">Inventory</a>
            <a href="Finance.php">Finance</a>
            <a href="offer.php">Offers</a>
            <a href="terms.php">Terms</a>
        </nav>
        <div class="user-badge">
            <span class="user-avatar"><?php echo htmlspecialchars(currentUserInitial()); ?></span>
            <span><?php echo htmlspecialchars(currentUserName()); ?></span>
        </div>
    </header>

    <main>
        <section class="landing-hero">
            <div class="hero-card">
                <div>
                    <div class="eyebrow">Premium automotive experience</div>
                    <h1>Discover, finance, and drive with confidence.</h1>
                    <p>Auto Hub brings together a curated vehicle inventory, a live financing calculator, exclusive offers, and a seamless account experience in one polished website.</p>
                </div>
                <div class="hero-actions">
                    <a class="btn-primary" href="create.php">Create Account</a>
                    <a class="btn-secondary" href="home.php">View Dashboard</a>
                </div>
            </div>
            <div class="side-card">
                <h3>What you can do here</h3>
                <p>Browse premium cars, compare monthly payments, unlock limited offers, and review terms in a modern experience tailored for luxury dealerships.</p>
                <p>Everything is built to feel like a complete product, not a collection of disconnected pages.</p>
            </div>
        </section>

        <section class="feature-grid">
            <div class="feature-card">
                <h4>Explore Inventory</h4>
                <p>Filter vehicles by type, search by name, and discover top-rated premium options.</p>
                <a href="Inventory.php">Open inventory →</a>
            </div>
            <div class="feature-card">
                <h4>Estimate Finance</h4>
                <p>Calculate your monthly payment instantly with real-time sliders and clear breakdowns.</p>
                <a href="Finance.php">Use calculator →</a>
            </div>
            <div class="feature-card">
                <h4>Unlock Offers</h4>
                <p>Access seasonal promotions, loyalty rewards, and exclusive customer discounts.</p>
                <a href="offer.php">View offers →</a>
            </div>
            <div class="feature-card">
                <h4>Read Terms</h4>
                <p>Review service conditions, financing notes, and platform policies in one place.</p>
                <a href="terms.php">See terms →</a>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <span>© 2026 Auto Hub • Designed to feel like a real dealership website.</span>
        <div class="footer-links">
            <a href="create.php">Sign In</a>
            <a href="Inventory.php">Inventory</a>
            <a href="Finance.php">Finance</a>
        </div>
    </footer>
</body>
</html>
