<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification d'identité | Flycom Services Back-office CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: #050E2D;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* ── Réseau de neurones ── */
        #loginParticles {
            position: absolute;
            inset: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }
        #loginParticles canvas { width: 100% !important; height: 100% !important; display: block; }

        /* ── Coins HUD ── */
        .hud-corner {
            position: fixed;
            font-size: 0.6rem;
            letter-spacing: 0.12em;
            color: rgba(0, 210, 244, 0.55);
            text-transform: uppercase;
            z-index: 10;
        }
        .hud-corner.tl { top: 18px; left: 22px; }
        .hud-corner.tr { top: 18px; right: 22px; }
        .hud-corner.bl { bottom: 18px; left: 22px; font-size: 0.55rem; color: rgba(255,255,255,0.25); }

        .hud-corner.tl::before,
        .hud-corner.tr::before {
            content: '';
            display: block;
            width: 28px;
            height: 1px;
            background: rgba(0, 210, 244, 0.4);
            margin-bottom: 4px;
        }
        .hud-corner.tr::before { margin-left: auto; }

        /* ── Card centrale ── */
        .login-card {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 380px;
            background: rgba(10, 22, 58, 0.72);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 210, 244, 0.18);
            border-radius: 1.25rem;
            padding: 2.5rem 2rem 2rem;
            box-shadow: 0 0 80px rgba(0, 210, 244, 0.06), 0 24px 60px rgba(0,0,0,0.55);
        }

        /* ── Logo ── */
        .logo-wrap {
            width: 58px; height: 58px;
            border-radius: 14px;
            background: linear-gradient(145deg, #00D2F4 0%, #1A48C0 100%);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 0 28px rgba(0, 210, 244, 0.5);
        }
        .logo-wrap i { font-size: 1.6rem; color: #fff; }

        /* ── Titre ── */
        .brand-title {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            color: #fff;
            text-align: center;
            margin-bottom: 0.15rem;
        }
        .brand-title .sep { color: rgba(0,210,244,0.7); margin: 0 4px; font-weight: 300; }
        .brand-title .crm { color: #00D2F4; }

        .brand-sub {
            text-align: center;
            font-size: 0.72rem;
            color: rgba(255,255,255,0.4);
            letter-spacing: 0.04em;
            margin-bottom: 2rem;
        }

        /* ── Labels ── */
        .field-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(165, 185, 215, 0.85);
            margin-bottom: 0.35rem;
            display: block;
        }

        /* ── Inputs ── */
        .input-wrap { position: relative; margin-bottom: 1.25rem; }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(0, 210, 244, 0.55);
            font-size: 0.95rem;
            pointer-events: none;
        }
        .form-field {
            width: 100%;
            background: rgba(5, 14, 45, 0.55);
            border: 1px solid rgba(0, 210, 244, 0.15);
            border-radius: 8px;
            padding: 0.7rem 2.8rem 0.7rem 2.6rem;
            font-size: 1.1rem;
            letter-spacing: 0.3em;
            text-align: center;
            color: #fff;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-field::placeholder { color: rgba(255,255,255,0.18); letter-spacing: normal; }
        .form-field:focus { border-color: rgba(0, 210, 244, 0.5); background: rgba(5, 14, 45, 0.7); }

        /* ── Bouton CTA ── */
        .btn-cta {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 8px;
            background: linear-gradient(90deg, #00C8EF 0%, #1A48C0 100%);
            color: #fff;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity 0.2s, transform 0.15s;
            box-shadow: 0 4px 20px rgba(0, 200, 240, 0.3);
        }
        .btn-cta:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-cta:active { transform: translateY(0); }

        /* ── Footer ── */
        .page-footer {
            position: fixed;
            bottom: 14px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.2);
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* ── Erreurs ── */
        .alert-errors {
            background: rgba(220,53,69,0.12);
            border: 1px solid rgba(220,53,69,0.3);
            border-radius: 8px;
            padding: 0.6rem 0.9rem;
            margin-bottom: 1.2rem;
            font-size: 0.8rem;
            color: #fff;
        }
        .alert-errors ul { margin: 0; padding-left: 1rem; }
    </style>
</head>
<body>

    <!-- Réseau de neurones -->
    <div id="loginParticles"></div>

    <!-- Coins HUD -->
    <div class="hud-corner tl">2-FACTOR</div>
    <div class="hud-corner tr">IDENTITY CONFIRMATION</div>
    <div class="hud-corner bl">FLYCOM · SECURITY PROTOCOL 2.0</div>

    <!-- Card de connexion -->
    <div class="login-card">

        <!-- Logo -->
        <div class="logo-wrap">
            <i class="bi bi-key-fill"></i>
        </div>

        <!-- Titre -->
        <div class="brand-title">FLYCOM<span class="sep">|</span><span class="crm">2FA</span></div>
        <div class="brand-sub">Entrez le code envoyé par e-mail</div>

        <!-- Notification de succès de renvoi du code OTP (Nouveau) -->
        @if (session('success'))
            <div class="alert alert-success py-2.5 px-3 rounded-3 mb-4 d-flex align-items-center gap-2 border-0 text-start" style="background-color: rgba(25, 135, 84, 0.12); color: #22C55E !important; font-size: 0.78rem; font-weight: 600;">
                <i class="bi bi-check-circle-fill"></i> 
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Erreurs de validation -->
        @if ($errors->any())
            <div class="alert-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('2fa.verify') }}" method="POST">
            @csrf

            <!-- Code OTP -->
            <label class="field-label" for="otpCode">Code de vérification</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-shield-lock"></i></span>
                <input
                    type="text"
                    name="otp_code"
                    id="otpCode"
                    class="form-field"
                    placeholder="••••••"
                    maxlength="6"
                    required
                    autofocus
                    autocomplete="one-time-code"
                >
            </div>

            <!-- Bouton de confirmation -->
            <button type="submit" class="btn-cta">
                <i class="bi bi-check-circle-fill"></i>
                Confirmer l'identité
            </button>
        </form>

        <!-- Formulaire secondaire pour la demande de renvoi (Nouveau) -->
        <form action="{{ route('2fa.resend') }}" method="POST" class="mt-4 text-center">
            @csrf
            <button type="submit" class="btn btn-link text-cyan text-decoration-none fs-8 fw-semibold" style="box-shadow: none; font-size: 0.75rem; color: #00D2F4; background: none; border: none; outline: none !important;">
                <i class="bi bi-arrow-clockwise me-1"></i> Renvoyer le code d'activation
            </button>
        </form>

    </div>

    <!-- Footer -->
    <div class="page-footer">FLYCOM SERVICES · GROUPE DIGIZONE · PROGRAMME D-CLIC OIF 2026</div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // ── Réseau de neurones ──
        const container = document.getElementById('loginParticles');
        const canvas    = document.createElement('canvas');
        const ctx       = canvas.getContext('2d');
        container.appendChild(canvas);

        let width, height, particles = [];
        const maxDistance = 120;

        const resize = () => {
            width  = container.offsetWidth;
            height = container.offsetHeight;
            canvas.width  = width;
            canvas.height = height;
        };

        const createParticles = () => {
            particles = [];
            const count = Math.min(Math.max(Math.floor((width * height) / 10000), 45), 110);
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    vx: (Math.random() - 0.5) * 0.45,
                    vy: (Math.random() - 0.5) * 0.45,
                    radius: Math.random() * 2.2 + 1.2
                });
            }
        };

        const draw = () => {
            ctx.clearRect(0, 0, width, height);
            for (let i = 0; i < particles.length; i++) {
                const p = particles[i];
                p.x += p.vx; p.y += p.vy;
                if (p.x < 0 || p.x > width)  p.vx *= -1;
                if (p.y < 0 || p.y > height) p.vy *= -1;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(0, 210, 244, 0.6)';
                ctx.fill();
            }
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < maxDistance) {
                        const alpha = (1 - dist / maxDistance) * 0.45;
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(0, 210, 244, ${alpha})`;
                        ctx.lineWidth = 0.9;
                        ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(draw);
        };

        resize();
        createParticles();
        draw();
        window.addEventListener('resize', () => { resize(); createParticles(); });
    });
    </script>
</body>
</html>