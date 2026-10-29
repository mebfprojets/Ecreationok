<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme en Maintenance - CEFORE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha384-iw3OoTErCYJJB9mCa8LNS2hbsQ7M3C0EpIsO/H5+EGAkPGc6rk+V8i04oW/K5xq0" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #c46844ff 0%, #4ba26bff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        .maintenance-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            max-width: 550px;
            width: 100%;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            max-height: 95vh;
            overflow: hidden;
        }

        .maintenance-icon {
            font-size: 70px;
            color: #de340eff;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        .maintenance-title {
            font-size: 2.2rem;
            color: #2d3748;
            margin-bottom: 15px;
            font-weight: 700;
            line-height: 1.2;
        }

        .maintenance-subtitle {
            font-size: 1.1rem;
            color: #4a5568;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .progress-container {
            background: #e2e8f0;
            border-radius: 10px;
            height: 6px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, #4cb220ff, #a94317ff);
            height: 100%;
            width: 65%;
            border-radius: 10px;
            animation: progress 2s ease-in-out infinite;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 20px 0;
        }

        .countdown-item {
            background: #c12708ff;
            color: white;
            padding: 12px 8px;
            border-radius: 8px;
            min-width: 60px;
            flex: 1;
            max-width: 80px;
        }

        .countdown-number {
            font-size: 1.5rem;
            font-weight: bold;
            display: block;
        }

        .countdown-label {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .maintenance-message {
            background: #f7fafc;
            border-left: 4px solid #3dd73bff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }

        .maintenance-message p {
            color: #931616ff;
            margin-bottom: 8px;
            line-height: 1.4;
            font-size: 0.9rem;
        }

        .contact-info {
            background: #edf2f7;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .contact-info h3 {
            color: #2d3748;
            margin-bottom: 12px;
            font-size: 1.1rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 8px 0;
            color: #4a5568;
            font-size: 0.9rem;
        }

        .contact-item .fas {
            min-width: 16px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 15px;
        }

        .social-link {
            width: 35px;
            height: 35px;
            background: #c8d219ff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .social-link:hover {
            background: #19b91cff;
            transform: translateY(-2px);
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-8px);
            }
            60% {
                transform: translateY(-4px);
            }
        }

        @keyframes progress {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(350%);
            }
        }

        /* Responsive pour très petits écrans */
        @media (max-width: 480px) {
            body {
                padding: 15px;
                align-items: flex-start;
            }

            .maintenance-container {
                padding: 30px 20px;
                max-height: none;
                height: auto;
            }

            .maintenance-title {
                font-size: 1.8rem;
            }

            .maintenance-subtitle {
                font-size: 1rem;
            }

            .maintenance-icon {
                font-size: 60px;
                margin-bottom: 15px;
            }

            .countdown-item {
                padding: 10px 6px;
                min-width: 50px;
            }

            .countdown-number {
                font-size: 1.3rem;
            }

            .countdown-label {
                font-size: 0.7rem;
            }

            .contact-item {
                font-size: 0.85rem;
                flex-wrap: wrap;
                text-align: center;
            }

            .contact-item span {
                flex: 1;
                min-width: 200px;
            }

            .maintenance-message p {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 360px) {
            .maintenance-container {
                padding: 25px 15px;
            }

            .maintenance-title {
                font-size: 1.6rem;
            }

            .countdown {
                gap: 8px;
            }

            .countdown-item {
                min-width: 45px;
                padding: 8px 4px;
            }

            .countdown-number {
                font-size: 1.2rem;
            }
        }

        /* Pour les très grandes hauteurs d'écran */
        @media (min-height: 900px) {
            .maintenance-container {
                padding: 50px 40px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>
        
        <h1 class="maintenance-title">Plateforme en Maintenance</h1>
        
        <p class="maintenance-subtitle">
            Nous améliorons notre plateforme pour vous offrir une meilleure expérience.
        </p>
        
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>

        <div class="countdown">
            <div class="countdown-item">
                <span class="countdown-number" id="hours">04</span>
                <span class="countdown-label">Heures</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="minutes">30</span>
                <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="seconds">00</span>
                <span class="countdown-label">Secondes</span>
            </div>
        </div>
        
        <div class="contact-info">
            <h3>📞 Contactez-nous</h3>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <span>info@me.bf</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <span>(+226) 02 21 21 21 - 58 80 77 77 - 56 62 02 02</span>
            </div>
        </div>

        <div class="social-links">
            <a href="#" class="social-link">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-link">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="social-link">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </div>

    <script nonce="{{ $cspNonce ?? '' }}">
        // Compte à rebours corrigé - version fonctionnelle
        function startCountdown() {
            // Définir la date/heure de fin de maintenance (4h30 dans le futur)
            const endTime = new Date();
            endTime.setHours(endTime.getHours() + 4);
            endTime.setMinutes(endTime.getMinutes() + 30);
            endTime.setSeconds(endTime.getSeconds() + 0);
            
            function updateCountdown() {
                const now = new Date();
                const timeLeft = endTime - now;
                
                if (timeLeft <= 0) {
                    // Maintenance terminée
                    document.getElementById('hours').textContent = '00';
                    document.getElementById('minutes').textContent = '00';
                    document.getElementById('seconds').textContent = '00';
                    clearInterval(countdownInterval);
                    
                    // Changer le message quand la maintenance est terminée
                    document.querySelector('.maintenance-subtitle').textContent = 'Maintenance terminée ! La plateforme sera bientôt disponible.';
                    return;
                }
                
                // Calculer heures, minutes, secondes
                const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                
                // Mettre à jour l'affichage
                document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
            }
            
            // Mettre à jour immédiatement
            updateCountdown();
            
            // Mettre à jour toutes les secondes
            const countdownInterval = setInterval(updateCountdown, 1000);
        }
        
        // Démarrer le compte à rebours quand la page est chargée
        document.addEventListener('DOMContentLoaded', startCountdown);

        // Empêcher le défilement avec la roulette de la souris
        document.addEventListener('wheel', function(e) {
            if (e.target.closest('.maintenance-container')) {
                e.preventDefault();
            }
        }, { passive: false });

        // Empêcher le défilement tactile sur mobile
        document.addEventListener('touchmove', function(e) {
            if (e.target.closest('.maintenance-container')) {
                e.preventDefault();
            }
        }, { passive: false });
    </script>
</body>
</html>