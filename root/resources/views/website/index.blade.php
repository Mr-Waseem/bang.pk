<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bang.pk - Digital Invoicing (FBR, PRA, KPRA, SRB &amp; BRA)</title>
    <link href="{{ asset('css/website-home.css') }}" rel="stylesheet">
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* About Us Section */
        .about-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
        }

        .about-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(37, 211, 102, 0.05) 0%, transparent 70%);
            z-index: 0;
        }

        .about-content {
            position: relative;
            z-index: 1;
        }

        .about-text {
            padding-right: 40px;
        }

        .about-text h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 25px;
            position: relative;
        }

        .about-text h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .about-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 25px;
        }

        .about-stats {
            display: flex;
            gap: 40px;
            margin-top: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            display: block;
            line-height: 1;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--gray-color);
            font-weight: 600;
            margin-top: 5px;
        }

        .about-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: perspective(1000px) rotateY(-5deg);
            transition: transform 0.5s ease;
        }

        .about-image:hover {
            transform: perspective(1000px) rotateY(0deg);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* About Images Grid - Modern Layout */
        .about-images-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 20px;
            position: relative;
        }

        .about-img-main {
            grid-row: span 2;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        }

        .about-img-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .about-img-main:hover img {
            transform: scale(1.08);
        }

        .about-img-side {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .about-img-top,
        .about-img-bottom {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .about-img-top img,
        .about-img-bottom img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .about-img-top:hover img,
        .about-img-bottom:hover img {
            transform: scale(1.08);
        }

        .img-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(17, 42, 100, 0.9) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .about-img-main:hover .img-overlay,
        .about-img-top:hover .img-overlay,
        .about-img-bottom:hover .img-overlay {
            opacity: 1;
        }

        .img-overlay span {
            color: white;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .img-overlay span i {
            color: #25D366;
            font-size: 1.2rem;
        }

        .about-floating-badge {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: linear-gradient(135deg, #112a64, #004e89);
            padding: 15px 20px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 15px 40px rgba(17, 42, 100, 0.4);
            z-index: 10;
            animation: badgePulse 3s ease-in-out infinite;
        }

        @keyframes badgePulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .about-floating-badge img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .about-floating-badge span {
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 992px) {
            .about-images-grid {
                margin-top: 40px;
            }

            .about-floating-badge {
                bottom: -15px;
                right: 10px;
            }
        }

        @media (max-width: 576px) {
            .about-images-grid {
                grid-template-columns: 1fr;
            }

            .about-img-main {
                grid-row: span 1;
            }

            .about-img-main img {
                height: 250px;
            }

            .about-img-side {
                flex-direction: row;
            }

            .about-img-top,
            .about-img-bottom {
                flex: 1;
            }

            .about-img-top img,
            .about-img-bottom img {
                height: 150px;
            }

            .about-floating-badge {
                bottom: auto;
                top: -15px;
                right: 10px;
                padding: 10px 15px;
            }

            .about-floating-badge img {
                width: 40px;
                height: 40px;
            }

            .about-floating-badge span {
                font-size: 0.8rem;
            }
        }

        /* Team Section */
        .team-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            position: relative;
        }

        .team-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.1), transparent);
        }

        .section-title {
            text-align: center;
            margin-bottom: 70px;
            position: relative;
        }

        .section-title h2 {
            font-size: 3.2rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .section-title p {
            font-size: 1.2rem;
            color: var(--gray-color);
            max-width: 600px;
            margin: 20px auto 0;
            line-height: 1.6;
        }

        .team-member {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 30px;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .team-member:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        }

        .member-image {
            width: 100%;
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .team-member:hover .member-image img {
            transform: scale(1.1);
        }

        .member-info {
            padding: 30px;
        }

        .member-info h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .member-info .position {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
            display: block;
        }

        .member-info p {
            color: var(--gray-color);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .member-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .member-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(37, 211, 102, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .member-social a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        /* Videos Section */
        .videos-section {
            padding: 100px 0;
            background: linear-gradient(to bottom, var(--light-color) 0%, #ffffff79 100%);
            position: relative;
        }

        .videos-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.05), transparent);
        }

        .video-item {
            background: rgba(0, 0, 0, 0.02);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 40px;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .video-item:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
        }

        .video-thumbnail {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            overflow: hidden;
            cursor: pointer;
            background: #000;
        }

        .video-thumbnail iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-thumbnail::after {
            content: '';
            position: relative;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.7) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .video-item:hover .video-thumbnail::after {
            opacity: 1;
        }

        .video-info {
            padding: 30px;
        }

        .video-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 20px;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .video-item:hover .video-info h3 {
            color: var(--primary-color);
        }

        .speaker-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(70, 255, 53, 0.05);
            border-radius: 12px;
        }

        .speaker-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .speaker-details h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0 0 5px 0;
        }

        .speaker-details p {
            font-size: 0.95rem;
            color: var(--gray-color);
            margin: 0;
            font-weight: 500;
        }

        .contact-info {
            display: flex;
            align-items: center;
            color: var(--primary-color);
            font-weight: 600;
            margin-top: 15px;
            padding: 12px 15px;
            background: rgba(73, 255, 53, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .video-item:hover .contact-info {
            background: rgba(63, 255, 53, 0.15);
            transform: translateX(5px);
        }

        .contact-info i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* ===== Google Reviews Section ===== */
        .google-reviews-section {
            padding: 120px 0;
            background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 50%, #f0f4f8 100%);
            position: relative;
            overflow: hidden;
        }

        .google-reviews-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #4285F4, #34A853, #FBBC05, #EA4335, transparent);
        }

        /* Floating Particles */
        .reviews-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .review-particle {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            opacity: 0.6;
            animation: particleFloat 12s ease-in-out infinite;
        }

        .review-particle:nth-child(1) {
            background: #4285F4;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
            animation-duration: 14s;
        }

        .review-particle:nth-child(2) {
            background: #EA4335;
            top: 20%;
            right: 8%;
            animation-delay: 2s;
            animation-duration: 16s;
        }

        .review-particle:nth-child(3) {
            background: #FBBC05;
            top: 60%;
            left: 3%;
            animation-delay: 4s;
            animation-duration: 12s;
        }

        .review-particle:nth-child(4) {
            background: #34A853;
            top: 80%;
            right: 12%;
            animation-delay: 6s;
            animation-duration: 18s;
        }

        .review-particle:nth-child(5) {
            background: #4285F4;
            top: 40%;
            left: 95%;
            animation-delay: 1s;
            animation-duration: 15s;
        }

        .review-particle:nth-child(6) {
            background: #EA4335;
            top: 70%;
            left: 8%;
            animation-delay: 3s;
            animation-duration: 13s;
        }

        .review-particle:nth-child(7) {
            background: #FBBC05;
            top: 15%;
            right: 20%;
            animation-delay: 5s;
            animation-duration: 17s;
        }

        .review-particle:nth-child(8) {
            background: #34A853;
            top: 90%;
            left: 50%;
            animation-delay: 7s;
            animation-duration: 11s;
        }

        @keyframes particleFloat {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0.6;
            }

            25% {
                transform: translate(20px, -30px) rotate(90deg);
                opacity: 0.8;
            }

            50% {
                transform: translate(-15px, -50px) rotate(180deg);
                opacity: 0.4;
            }

            75% {
                transform: translate(25px, -20px) rotate(270deg);
                opacity: 0.7;
            }
        }

        /* 3D Rotating Stars */
        .reviews-3d-element {
            position: absolute;
            top: 50%;
            right: 5%;
            width: 120px;
            height: 120px;
            transform-style: preserve-3d;
            animation: rotate3DElement 20s linear infinite;
            opacity: 0.15;
            pointer-events: none;
        }

        .reviews-3d-element::before,
        .reviews-3d-element::after {
            content: '★';
            position: absolute;
            font-size: 3rem;
            color: #FBBC05;
        }

        .reviews-3d-element::before {
            transform: rotateY(0deg) translateZ(60px);
        }

        .reviews-3d-element::after {
            transform: rotateY(180deg) translateZ(60px);
        }

        .reviews-3d-element .star-face {
            position: absolute;
            font-size: 3rem;
            color: #FBBC05;
        }

        .reviews-3d-element .star-face:nth-child(1) {
            transform: rotateY(90deg) translateZ(60px);
        }

        .reviews-3d-element .star-face:nth-child(2) {
            transform: rotateY(270deg) translateZ(60px);
        }

        @keyframes rotate3DElement {
            0% {
                transform: translateY(-50%) rotateY(0deg) rotateX(15deg);
            }

            100% {
                transform: translateY(-50%) rotateY(360deg) rotateX(15deg);
            }
        }

        /* Left side 3D element */
        .reviews-3d-left {
            position: absolute;
            top: 30%;
            left: 3%;
            width: 80px;
            height: 80px;
            transform-style: preserve-3d;
            animation: rotate3DLeft 15s linear infinite reverse;
            opacity: 0.12;
            pointer-events: none;
        }

        .reviews-3d-left::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 4px solid #4285F4;
            border-radius: 15px;
            animation: morphShape 8s ease-in-out infinite;
        }

        @keyframes rotate3DLeft {
            0% {
                transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);
            }

            100% {
                transform: rotateX(360deg) rotateY(360deg) rotateZ(360deg);
            }
        }

        @keyframes morphShape {

            0%,
            100% {
                border-radius: 15px;
            }

            50% {
                border-radius: 50%;
            }
        }

        /* Floating Google Colors Background */
        .google-bg-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .google-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.15;
            animation: googleFloat 15s ease-in-out infinite;
        }

        .google-orb.blue {
            background: #4285F4;
            width: 400px;
            height: 400px;
            top: -100px;
            left: 10%;
            animation-delay: 0s;
        }

        .google-orb.red {
            background: #EA4335;
            width: 300px;
            height: 300px;
            bottom: -50px;
            right: 15%;
            animation-delay: 3s;
        }

        .google-orb.yellow {
            background: #FBBC05;
            width: 350px;
            height: 350px;
            top: 50%;
            left: -100px;
            animation-delay: 6s;
        }

        .google-orb.green {
            background: #34A853;
            width: 280px;
            height: 280px;
            bottom: 20%;
            right: -80px;
            animation-delay: 9s;
        }

        @keyframes googleFloat {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            25% {
                transform: translate(30px, -30px) scale(1.1);
            }

            50% {
                transform: translate(-20px, 20px) scale(0.95);
            }

            75% {
                transform: translate(20px, 30px) scale(1.05);
            }
        }

        /* Google Rating Header */
        .google-rating-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .google-logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            background: white;
            padding: 20px 40px;
            border-radius: 60px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .google-logo-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .google-logo-badge::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, #4285F4, #34A853, #FBBC05, #EA4335);
            border-radius: 60px;
            z-index: -1;
            animation: borderRotate 4s linear infinite;
        }

        .google-logo-badge::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            background: white;
            border-radius: 58px;
            z-index: -1;
        }

        @keyframes borderRotate {
            0% {
                filter: hue-rotate(0deg);
            }

            100% {
                filter: hue-rotate(360deg);
            }
        }

        .google-logo-badge img {
            height: 40px;
        }

        .google-logo-badge .google-text {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #4285F4, #34A853);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .overall-rating {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .rating-score {
            display: flex;
            align-items: baseline;
            gap: 5px;
        }

        .rating-score .score {
            font-size: 5rem;
            font-weight: 800;
            color: var(--dark-color);
            line-height: 1;
        }

        .rating-score .out-of {
            font-size: 1.5rem;
            color: #6b7280;
            font-weight: 600;
        }

        .rating-stars {
            display: flex;
            gap: 8px;
        }

        .rating-stars i {
            font-size: 2rem;
            color: #FBBC05;
            animation: starPulse 2s ease-in-out infinite;
        }

        .rating-stars i:nth-child(1) {
            animation-delay: 0s;
        }

        .rating-stars i:nth-child(2) {
            animation-delay: 0.2s;
        }

        .rating-stars i:nth-child(3) {
            animation-delay: 0.4s;
        }

        .rating-stars i:nth-child(4) {
            animation-delay: 0.6s;
        }

        .rating-stars i:nth-child(5) {
            animation-delay: 0.8s;
        }

        @keyframes starPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }
        }

        .review-count {
            font-size: 1.1rem;
            color: #6b7280;
            margin-top: 10px;
        }

        .review-count span {
            color: #4285F4;
            font-weight: 700;
        }

        /* Reviews Slider */
        .reviews-slider {
            position: relative;
            z-index: 2;
        }

        .reviews-viewport {
            overflow: hidden;
            border-radius: 28px;
            padding: 10px;
            perspective: 1200px;
        }

        .reviews-track {
            display: grid;
            grid-auto-flow: column;
            grid-auto-columns: calc(33.333% - 20px);
            gap: 30px;
            align-items: stretch;
            transform-style: preserve-3d;
            transition: transform 0.7s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }

        .review-card {
            background: white;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            transition: transform 0.6s ease, box-shadow 0.6s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.04);
            transform: translateZ(0) rotateX(0deg);
            display: flex;
            flex-direction: column;
            min-height: 360px;
            height: 100%;
        }

        .review-card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
            padding-right: 48px;
        }

        .review-card.is-center {
            transform: translateZ(40px) rotateX(2deg);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.12);
        }

        .review-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4285F4, #34A853, #FBBC05, #EA4335);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .review-card:hover::before {
            transform: scaleX(1);
        }

        /* Card shimmer effect */
        .review-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.8s ease;
            pointer-events: none;
        }

        .review-card:hover::after {
            left: 150%;
        }

        /* Corner glow effect */
        .review-card .corner-glow {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
        }

        .review-card .corner-glow.top-left {
            top: -30px;
            left: -30px;
            background: #4285F4;
        }

        .review-card .corner-glow.bottom-right {
            bottom: -30px;
            right: -30px;
            background: #34A853;
        }

        .review-card:hover .corner-glow {
            opacity: 0.3;
        }

        .review-card:hover {
            transform: translateY(-12px) translateZ(30px) rotateX(2deg);
            box-shadow: 0 28px 70px rgba(0, 0, 0, 0.14);
        }

        .review-google-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4285F4, #1a73e8);
            color: #fff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.1rem;
            box-shadow: 0 6px 18px rgba(66, 133, 244, 0.3);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .review-google-badge:hover {
            transform: scale(1.08);
            color: #fff !important;
            box-shadow: 0 8px 22px rgba(66, 133, 244, 0.4);
        }

        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .reviewer-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f0f4f8;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Animated Initial Avatar */
        .reviewer-initial {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transform-style: preserve-3d;
            animation: avatarFloat 4s ease-in-out infinite;
            flex-shrink: 0;
        }

        .reviewer-initial::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 40%, rgba(255, 255, 255, 0.3) 50%, transparent 60%);
            animation: avatarShimmer 3s ease-in-out infinite;
        }

        .reviewer-initial::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: avatarPulseRing 2s ease-in-out infinite;
        }

        @keyframes avatarFloat {

            0%,
            100% {
                transform: translateY(0) rotateZ(0deg);
            }

            50% {
                transform: translateY(-5px) rotateZ(3deg);
            }
        }

        @keyframes avatarShimmer {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            50%,
            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        @keyframes avatarPulseRing {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        /* Google color gradients for initials */
        .reviewer-initial.color-blue {
            background: linear-gradient(135deg, #4285F4, #1a73e8);
        }

        .reviewer-initial.color-red {
            background: linear-gradient(135deg, #EA4335, #c5221f);
        }

        .reviewer-initial.color-yellow {
            background: linear-gradient(135deg, #FBBC05, #f9a825);
        }

        .reviewer-initial.color-green {
            background: linear-gradient(135deg, #34A853, #1e8e3e);
        }

        .reviewer-initial.color-purple {
            background: linear-gradient(135deg, #9c27b0, #7b1fa2);
        }

        .reviewer-initial.color-orange {
            background: linear-gradient(135deg, #ff6d00, #e65100);
        }

        /* Hover 3D effect on card lifts initial */
        .review-card:hover .reviewer-initial {
            animation: avatarBounce 0.5s ease;
        }

        @keyframes avatarBounce {

            0%,
            100% {
                transform: scale(1) rotateY(0deg);
            }

            25% {
                transform: scale(1.1) rotateY(-15deg);
            }

            75% {
                transform: scale(1.1) rotateY(15deg);
            }
        }

        .reviewer-details h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0 0 5px 0;
        }

        .reviewer-details .review-date {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .review-stars {
            display: flex;
            gap: 4px;
            margin-bottom: 15px;
        }

        .review-stars i {
            color: #FBBC05;
            font-size: 1.1rem;
            transition: transform 0.3s ease, text-shadow 0.3s ease;
            animation: starTwinkle 2s ease-in-out infinite;
        }

        .review-stars i:nth-child(1) {
            animation-delay: 0s;
        }

        .review-stars i:nth-child(2) {
            animation-delay: 0.15s;
        }

        .review-stars i:nth-child(3) {
            animation-delay: 0.3s;
        }

        .review-stars i:nth-child(4) {
            animation-delay: 0.45s;
        }

        .review-stars i:nth-child(5) {
            animation-delay: 0.6s;
        }

        @keyframes starTwinkle {

            0%,
            100% {
                transform: scale(1) rotateY(0deg);
                text-shadow: 0 0 0 transparent;
            }

            50% {
                transform: scale(1.15) rotateY(180deg);
                text-shadow: 0 0 10px rgba(251, 188, 5, 0.6);
            }
        }

        .review-card:hover .review-stars i {
            animation: starBurst 0.6s ease forwards;
        }

        @keyframes starBurst {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3) rotateZ(15deg);
            }

            100% {
                transform: scale(1.1);
            }
        }

        .review-text {
            color: #4b5563;
            line-height: 1.8;
            font-size: 1rem;
            position: relative;
            margin-bottom: 0;
            flex: 1;
            min-height: 0;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .review-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px dashed rgba(66, 133, 244, 0.15);
            flex-shrink: 0;
        }

        .review-google-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0;
            background: none;
            border-radius: 0;
            color: #64748b !important;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: none;
            transition: color 0.2s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .review-google-link:hover {
            transform: none;
            box-shadow: none;
            color: #4285F4 !important;
            text-decoration: underline;
        }

        .review-google-link .google-g-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
            flex-shrink: 0;
        }

        /* Slider Controls */
        .reviews-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 35px;
        }

        .reviews-btn {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: none;
            background: white;
            color: #1a73e8;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .reviews-btn:hover {
            transform: translateY(-4px) rotateZ(5deg);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
            background: linear-gradient(135deg, #4285F4, #1a73e8);
            color: white;
        }

        .reviews-btn:active {
            transform: translateY(-2px) scale(0.95);
        }

        .reviews-btn i {
            transition: transform 0.3s ease;
        }

        .reviews-btn:hover i {
            animation: arrowBounce 0.5s ease;
        }

        @keyframes arrowBounce {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-3px);
            }
        }

        .reviews-btn[data-next]:hover i {
            animation: arrowBounceRight 0.5s ease;
        }

        @keyframes arrowBounceRight {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(3px);
            }
        }

        .reviews-dots {
            display: flex;
            gap: 10px;
        }

        .reviews-dot {
            width: 10px;
            height: 10px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }

        .reviews-dot::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 999px;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }

        .reviews-dot.active::before {
            border-color: rgba(66, 133, 244, 0.3);
            animation: dotRipple 1.5s ease-in-out infinite;
        }

        @keyframes dotRipple {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        .reviews-dot:hover:not(.active) {
            background: rgba(66, 133, 244, 0.5);
            transform: scale(1.2);
        }

        .reviews-dot-old {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(66, 133, 244, 0.25);
            transition: width 0.3s ease, background 0.3s ease;
        }

        .reviews-dot.active {
            width: 28px;
            background: linear-gradient(90deg, #4285F4, #34A853);
        }

        .google-verified {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 0;
            padding: 8px 15px;
            background: rgba(66, 133, 244, 0.06);
            border-radius: 20px;
            font-size: 0.85rem;
            color: #4285F4;
            font-weight: 600;
        }

        .google-verified i {
            color: #34A853;
        }

        /* Reviews Responsive */
        @media (max-width: 992px) {
            .reviews-track {
                grid-auto-columns: calc(50% - 15px);
            }

            .rating-score .score {
                font-size: 4rem;
            }

            .rating-stars i {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 768px) {
            .google-reviews-section {
                padding: 80px 0;
            }

            .reviews-track {
                grid-auto-columns: 100%;
                gap: 20px;
            }

            .google-logo-badge {
                padding: 15px 30px;
            }

            .google-logo-badge img {
                height: 30px;
            }

            .google-logo-badge .google-text {
                font-size: 1.4rem;
            }

            .rating-score .score {
                font-size: 3.5rem;
            }

            .overall-rating {
                flex-direction: column;
                gap: 15px;
            }

            .review-card {
                padding: 25px;
                min-height: 320px;
            }

            .review-text {
                -webkit-line-clamp: 3;
            }

            .review-card-footer {
                flex-wrap: wrap;
            }

        }

        /* Partners Section */
        .partners-section {
            padding: 120px 0;
            background:
                linear-gradient(135deg, rgba(37, 211, 102, 0.03) 0%, rgba(0, 78, 137, 0.05) 100%),
                linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            position: relative;
            overflow: hidden;
        }

        .partners-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(37, 211, 102, 0.4), rgba(0, 78, 137, 0.4), transparent);
            box-shadow: 0 0 20px rgba(37, 211, 102, 0.3);
        }

        .partners-section::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37, 211, 102, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .partners-section .section-title {
            position: relative;
            z-index: 2;
        }

        .partners-section .section-title h2 {
            background: linear-gradient(135deg, var(--dark-color), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .partner-logo {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 20px;
            padding: 0 25px;
            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .partner-logo::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color), var(--secondary-color));
            border-radius: 20px;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.5s ease;
        }

        .partner-logo::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 211, 102, 0.15), transparent);
            transition: left 0.8s ease;
        }

        .partner-logo:hover::after {
            left: 100%;
        }

        .partner-logo:hover::before {
            opacity: 1;
            animation: borderGlow 2s infinite;
        }

        @keyframes borderGlow {

            0%,
            100% {
                opacity: 0.8;
                filter: brightness(1);
            }

            50% {
                opacity: 1;
                filter: brightness(1.2);
            }
        }

        .partner-logo:hover {
            transform: translateY(-12px) scale(1.05);
            box-shadow:
                0 20px 50px rgba(37, 211, 102, 0.2),
                0 10px 30px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 1);
            background: linear-gradient(145deg, #ffffff, #fafbfc);
        }

        .partner-logo-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .partner-logo img {
            max-width: 85%;
            max-height: 70px;
            object-fit: contain;
            filter: grayscale(100%) brightness(0.7) contrast(0.9);
            transition: all 0.5s ease;
            position: relative;
            z-index: 1;
        }

        .partner-logo:hover img {
            filter: grayscale(0%) brightness(1) contrast(1);
            transform: scale(1.15);
        }

        .partner-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .partner-logo:hover .partner-badge {
            opacity: 1;
            transform: translateY(0);
        }

        .partners-grid {
            position: relative;
            z-index: 2;
        }

        /* Redesigned Partner Statistics - premium stat cards */
        .partner-stats {
            margin-top: 60px;
            padding: 30px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.85), rgba(248, 249, 250, 0.85));
            border-radius: 18px;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: visible;
        }

        .partner-stats::before {
            content: '';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 6px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--secondary-color));
            filter: blur(8px);
            opacity: 0.65;
        }

        .partner-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            position: relative;
            z-index: 2;
        }

        .stat-card {
            background: linear-gradient(180deg, #ffffff, #fbfcfd);
            border-radius: 14px;
            padding: 18px 18px;
            display: flex;
            gap: 14px;
            align-items: center;
            box-shadow: 0 10px 30px rgba(13, 38, 76, 0.06);
            border-left: 6px solid transparent;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 22px 50px rgba(13, 38, 76, 0.12);
            border-left-color: var(--primary-color);
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(37, 211, 102, 0.12), rgba(0, 78, 137, 0.08));
            color: var(--primary-color);
            font-size: 26px;
            flex-shrink: 0;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }

        .stat-info {
            flex: 1;
        }

        .stat-number {
            font-size: 2.4rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            display: block;
            margin-top: 6px;
            font-size: 0.9rem;
            color: var(--dark-color);
            font-weight: 700;
        }

        .stat-desc {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 6px;
        }

        .stat-progress {
            height: 6px;
            background: rgba(0, 0, 0, 0.06);
            border-radius: 6px;
            margin-top: 10px;
            overflow: hidden;
        }

        .stat-progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transition: width 1.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* responsive adjustments */
        @media (max-width: 992px) {
            .partner-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .partner-stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 14px;
                gap: 12px;
            }

            .stat-icon {
                width: 56px;
                height: 56px;
                font-size: 22px;
            }

            .stat-number {
                font-size: 2rem;
            }

            .stat-desc {
                font-size: 0.82rem;
            }
        }

        /* Become Partner Section */
        .become-partner-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f2f2f2ff 0%, #00000024 100%);
            position: relative;
            overflow: hidden;
        }

        .become-partner-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .become-partner-section .section-title h2,
        .become-partner-section .section-title p {
            color: black;
        }

        .partner-form-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 211, 102, 0.2);
        }

        .form-control::placeholder {
            color: #999;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23112a64' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 20px center;
            background-size: 16px;
            padding-right: 50px;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 18px 45px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            margin-top: 30px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            transition: left 0.5s ease;
            z-index: -1;
            border-radius: 50px;
        }

        .submit-btn:hover::before {
            left: 0;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(37, 211, 102, 0.4);
        }

        .partner-benefits {
            background: rgba(255, 255, 255, 1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin-top: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .partner-benefits h3 {
            color: black;
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .benefit-item {
            background: rgb(23 61 245 / 10%);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .benefit-item:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
        }

        .benefit-item i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: block;
        }

        .benefit-item h4 {
            color: black;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .benefit-item p {
            color: rgba(0, 0, 0, 1);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Loading animation for videos */
        .video-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 1;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .hero-content h1 {
                font-size: 3.5rem;
            }

            .section-title h2 {
                font-size: 2.8rem;
            }

            .about-text h2 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 992px) {
            .hero-content h1 {
                font-size: 3rem;
            }

            .hero-content p {
                font-size: 1.3rem;
            }

            .section-title h2 {
                font-size: 2.5rem;
            }

            .video-info h3 {
                font-size: 1.4rem;
            }

            .about-text {
                padding-right: 0;
                margin-bottom: 40px;
            }

            .about-stats {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .section-title {
                margin-bottom: 50px;
            }

            .section-title h2 {
                font-size: 2.2rem;
            }

            .section-title p {
                font-size: 1.1rem;
                padding: 0 15px;
            }

            .video-item {
                margin-bottom: 30px;
            }

            .video-info {
                padding: 20px;
            }

            .speaker-info {
                padding: 12px;
            }

            .partner-logo {
                height: 140px;
                padding: 0 20px;
                margin-bottom: 20px;
            }

            .partner-logo img {
                max-height: 55px;
            }

            .partner-badge {
                top: 10px;
                right: 10px;
                padding: 4px 10px;
                font-size: 0.65rem;
            }

            .partner-stats {
                flex-wrap: wrap;
                gap: 30px;
                padding: 30px 20px;
            }

            .partner-stat-item {
                flex: 1 0 calc(50% - 15px);
            }

            .partner-stat-item::after {
                display: none;
            }

            .partner-stat-number {
                font-size: 2.2rem;
            }

            .partner-stat-label {
                font-size: 0.85rem;
            }

            .about-text h2 {
                font-size: 2.2rem;
            }

            .member-image {
                height: 250px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .partner-form-container {
                padding: 25px;
            }
        }

        .partner-logo img {
            max-height: 100px;
            border-radius: 10px;
        }

        .partner-stats {
            gap: 20px;
            padding: 25px 15px;
        }

        .partner-stat-item {
            flex: 1 0 100%;
        }

        .partner-stat-number {
            font-size: 2rem;
        }

        .partner-stat-label {
            font-size: 0.8rem .become-partner-section {
                padding: 70px 0;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
            }

            .benefit-item {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .navbar-brand {
                font-size: 1.8rem;
            }

            .video-info h3 {
                font-size: 1.3rem;
            }

            .partner-logo {
                height: 100px;
                padding: 0 15px;
            }

            .logo-container img {
                margin: 10px;
            }

            .about-stats {
                gap: 20px;
                flex-wrap: wrap;
            }

            .stat-item {
                flex: 1 0 calc(50% - 20px);
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    @include('website.include.header')

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <span class="hero-eyebrow"><i class="fas fa-shield-alt"></i> Multi-Authority Digital Invoicing</span>
                    <h1><span class="hero-initial-text">BANG ERP</span> — Pakistan's Complete Digital Invoicing Platform</h1>
                    <p>Streamline sales tax compliance with real-time integration for FBR, FBR POS, PRA, KPRA, SRB and BRA — automated invoices and enterprise reporting, trusted by 700+ businesses nationwide.</p>
                    <div class="hero-cta-group">
                        <a href="{{ asset('login') }}" class="hero-btn-primary"><i class="fas fa-rocket"></i> Login Now</a>
                        <a href="#become-partner" class="hero-btn-outline"><i class="fas fa-handshake"></i> Become Partner</a>
                    </div>
                    <div class="hero-chips">
                        <span class="hero-chip"><i class="fas fa-check-circle"></i> FBR · PRA · KPRA · SRB · BRA</span>
                        <span class="hero-chip"><i class="fas fa-check-circle"></i> Real-time Sync</span>
                        <span class="hero-chip"><i class="fas fa-check-circle"></i> 24/7 Support</span>
                    </div>
                </div>
                <div class="hero-glass-card">
                    <div class="hero-glass-header">
                        <span class="hero-glass-title"><i class="fas fa-chart-bar me-2"></i>Invoice Dashboard</span>
                        <span class="hero-fbr-pill"><i class="fas fa-check-circle"></i> Tax Synced</span>
                    </div>
                    <div class="hero-mini-stats">
                        <div class="hero-mini-stat">
                            <span class="val">1,247</span>
                            <span class="lbl">Today's Invoices</span>
                        </div>
                        <div class="hero-mini-stat">
                            <span class="val">PKR 8.4M</span>
                            <span class="lbl">Total Sales</span>
                        </div>
                        <div class="hero-mini-stat">
                            <span class="val">100%</span>
                            <span class="lbl">Compliance</span>
                        </div>
                    </div>
                    <table class="hero-mini-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INV-2847</td>
                                <td>ABC Traders</td>
                                <td>PKR 45,200</td>
                                <td class="approved">Approved</td>
                            </tr>
                            <tr>
                                <td>INV-2846</td>
                                <td>XYZ Corp</td>
                                <td>PKR 128,500</td>
                                <td class="approved">Approved</td>
                            </tr>
                            <tr>
                                <td>INV-2845</td>
                                <td>Metro Retail</td>
                                <td>PKR 67,800</td>
                                <td class="approved">Approved</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hero-logo-strip">
                <img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" alt="FBR Digital Invoicing System">
                <img src="{{ asset('root/upload/logo/fbrlogo1.jpg') }}" alt="FBR POS Invoicing System">
                <img src="{{ asset('root/upload/logo/pra.jpg') }}" alt="PRA Punjab Revenue Authority">
                <img src="{{ asset('root/upload/logo/kpra.jpg') }}" alt="KPRA Khyber Pakhtunkhwa Revenue Authority">
                <img src="{{ asset('root/upload/logo/srb.jpg') }}" alt="SRB Sindh Revenue Board">
                <img src="{{ asset('root/upload/logo/bra.jpg') }}" alt="BRA Balochistan Revenue Authority">
            </div>
        </div>
    </section>

    <!-- Trust Bar -->
    <section class="trust-bar" aria-label="Trust metrics">
        <div class="container">
            <div class="trust-bar-grid">
                <div class="trust-metric">
                    <div class="trust-metric-value" data-target="700" data-suffix="+">0</div>
                    <div class="trust-metric-label">Businesses</div>
                </div>
                <div class="trust-metric">
                    <div class="trust-metric-value" data-target="1" data-suffix="M+">0</div>
                    <div class="trust-metric-label">Invoices Processed</div>
                </div>
                <div class="trust-metric">
                    <div class="trust-metric-value" data-target="50" data-suffix="+">0</div>
                    <div class="trust-metric-label">Cities</div>
                </div>
                <div class="trust-metric">
                    <div class="trust-metric-value" data-target="99.9" data-suffix="%" data-decimals="1">0</div>
                    <div class="trust-metric-label">Uptime</div>
                </div>
                <div class="trust-metric">
                    <div class="trust-metric-value" data-target="24" data-suffix="/7">0</div>
                    <div class="trust-metric-label">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-eyebrow">Features</span>
                <h2>Everything You Need for Tax Compliance</h2>
                <p>Powerful tools for Pakistani businesses — FBR, FBR POS, PRA, KPRA, SRB and BRA — from invoicing to reporting in one platform.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-plug"></i></div>
                    <h3>Multi-Authority API</h3>
                    <p>Real-time connection with FBR, PRA, KPRA, SRB and BRA systems for instant invoice validation and submission.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <h3>Sales Tax Invoice</h3>
                    <p>Generate authority-compliant sales tax invoices with automatic tax calculations, QR codes, and unique invoice numbers.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-cash-register"></i></div>
                    <h3>POS Integration</h3>
                    <p>Point-of-sale integration for retail with instant FBR POS, PRA, KPRA and SRB invoice generation at checkout.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-envelope-open-text"></i></div>
                    <h3>PDF &amp; Email</h3>
                    <p>Auto-generate professional PDF invoices and email them directly to customers with one click.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-building"></i></div>
                    <h3>Multi-Company ERP</h3>
                    <p>Manage multiple companies and branches from a single dashboard with role-based access control.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
                    <h3>Reports &amp; Analytics</h3>
                    <p>Comprehensive sales, tax, and compliance reports with export options for audit and filing.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="how-section">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-eyebrow">How It Works</span>
                <h2>Get Started in 4 Simple Steps</h2>
                <p>From registration to your first compliant invoice — FBR, PRA, KPRA, SRB or BRA — we make the process effortless.</p>
            </div>
            <div class="how-steps">
                <div class="how-step">
                    <div class="how-step-num">1</div>
                    <h3>Sign Up</h3>
                    <p>Register your business and create your BANG ERP account in minutes.</p>
                </div>
                <div class="how-step">
                    <div class="how-step-num">2</div>
                    <h3>Configure Authority</h3>
                    <p>Connect FBR, PRA, KPRA, SRB or BRA credentials and set up your tax profile and business details.</p>
                </div>
                <div class="how-step">
                    <div class="how-step-num">3</div>
                    <h3>Create Invoices</h3>
                    <p>Generate sales tax invoices with automatic tax calculations and QR codes.</p>
                </div>
                <div class="how-step">
                    <div class="how-step-num">4</div>
                    <h3>Submit &amp; Sync</h3>
                    <p>Invoices are validated and submitted to your tax authority in real-time — fully compliant.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Videos Section -->
    <section id="videos" class="videos-section">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-eyebrow">Testimonials</span>
                <h2>What Clients Say About Us</h2>
                <p>Watch inspiring reviews from industry leaders and experts about their experiences with us</p>
            </div>

            <div class="videos-carousel" data-video-carousel>
                <div class="videos-carousel-viewport">
                    <div class="videos-carousel-track">
                        <div class="video-item">
                            <div class="video-thumbnail">
                                <div class="video-loading"></div>
                                <iframe src="https://www.youtube.com/embed/tC5TE10MJEs?si=8sKF4_JFzfO-l6_z"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    loading="lazy"></iframe>
                            </div>
                            <div class="video-info">
                                <div class="video-info-header">
                                    <h3>Tax Professional &amp; Consultant</h3>
                                    <span class="role-badge"><i class="fas fa-user-tie"></i> Consultant</span>
                                </div>
                                <div class="speaker-info">
                                    <div class="speaker-initial-avatar">K</div>
                                    <div class="speaker-details">
                                        <h5>Khurram Ikhlaq</h5>
                                        <p>CFO at Akiza Associates</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="video-item">
                            <div class="video-thumbnail">
                                <iframe data-src="https://www.youtube.com/embed/YdHzFtRGRyk?si=KVUoCJLHzbEGCGgm" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="video-info">
                                <div class="video-info-header">
                                    <h3>Tax Professional &amp; Consultant</h3>
                                    <span class="role-badge"><i class="fas fa-user-tie"></i> Consultant</span>
                                </div>
                                <div class="speaker-info">
                                    <div class="speaker-initial-avatar">M</div>
                                    <div class="speaker-details">
                                        <h5>Muhammad Aoun Abbas</h5>
                                        <p>Sh. Sharif Hussain &amp; Co</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="video-item">
                            <div class="video-thumbnail">
                                <iframe data-src="https://www.youtube.com/embed/YfZ1_SRud0U?si=86PXV8BM-toE3QLT" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="video-info">
                                <div class="video-info-header">
                                    <h3>CEO</h3>
                                    <span class="role-badge"><i class="fas fa-briefcase"></i> CEO</span>
                                </div>
                                <div class="speaker-info">
                                    <div class="speaker-initial-avatar">Z</div>
                                    <div class="speaker-details">
                                        <h5>Zaid Ch</h5>
                                        <p>CEO as AS Dyeing PVT LTD</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="video-item">
                            <div class="video-thumbnail">
                                <iframe data-src="https://www.youtube.com/embed/oNozGSXLvyQ?si=av3ADDNL0d3-19eE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="video-info">
                                <div class="video-info-header">
                                    <h3>Tax Professional &amp; Consultant</h3>
                                    <span class="role-badge"><i class="fas fa-user-tie"></i> Consultant</span>
                                </div>
                                <div class="speaker-info">
                                    <div class="speaker-initial-avatar">K</div>
                                    <div class="speaker-details">
                                        <h5>Kashif Saeed</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="video-item">
                            <div class="video-thumbnail">
                                <iframe data-src="https://www.youtube.com/embed/pOq1DXO3jmI?si=9UmYvJDUzmze1nPo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="video-info">
                                <div class="video-info-header">
                                    <h3>Tax Professional &amp; Consultant</h3>
                                    <span class="role-badge"><i class="fas fa-user-tie"></i> Consultant</span>
                                </div>
                                <div class="speaker-info">
                                    <div class="speaker-initial-avatar">M</div>
                                    <div class="speaker-details">
                                        <h5>Muhammad Ramzan Ch</h5>
                                        <p>Mindwork Law Associates</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="videos-carousel-controls">
                    <button type="button" class="videos-carousel-btn" data-video-prev aria-label="Previous videos"><i class="fas fa-chevron-left"></i></button>
                    <div class="videos-carousel-dots" data-video-dots></div>
                    <button type="button" class="videos-carousel-btn" data-video-next aria-label="Next videos"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Reviews Section -->
    @php $googleReviewUrl = 'https://maps.app.goo.gl/MvgTxXFGxpdxrpFA9'; @endphp
    <section id="google-reviews" class="google-reviews-section">
        <!-- Background Elements -->
        <div class="google-bg-elements">
            <div class="google-orb blue"></div>
            <div class="google-orb red"></div>
            <div class="google-orb yellow"></div>
            <div class="google-orb green"></div>
        </div>

        <!-- Floating Particles -->
        <div class="reviews-particles">
            <div class="review-particle"></div>
            <div class="review-particle"></div>
            <div class="review-particle"></div>
            <div class="review-particle"></div>
            <div class="review-particle"></div>
            <div class="review-particle"></div>
            <div class="review-particle"></div>
            <div class="review-particle"></div>
        </div>

        <!-- 3D Rotating Elements -->
        <div class="reviews-3d-element">
            <span class="star-face">★</span>
            <span class="star-face">★</span>
        </div>
        <div class="reviews-3d-left"></div>

        <div class="container">
            <!-- Google Rating Header -->
            <div class="google-rating-header">
                <a href="{{ $googleReviewUrl }}" target="_blank" rel="noopener noreferrer" class="google-logo-badge" aria-label="Click here to check ratings on Google">
                    <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png" alt="Google">
                    <span class="google-text">Reviews</span>
                </a>

                <div class="overall-rating">
                    <div class="rating-score">
                        <span class="score">5</span>
                        <span class="out-of">/5</span>
                    </div>
                    <div class="rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <!-- <p class="review-count">Based on <span>500+</span> verified Google reviews</p> -->
            </div>

            <!-- Reviews Slider -->
            <div class="reviews-slider" data-slider>
                <div class="reviews-viewport">
                    <div class="reviews-track">
                        @php $avatarColors = ['color-blue', 'color-red', 'color-green', 'color-yellow', 'color-purple', 'color-orange']; @endphp
                        @foreach($ratings as $rating)
                        <div class="review-card">
                            <div class="corner-glow top-left"></div>
                            <div class="corner-glow bottom-right"></div>
                            <a href="{{ $googleReviewUrl }}" target="_blank" rel="noopener noreferrer" class="review-google-badge" aria-label="View on Google">
                                <i class="fab fa-google"></i>
                            </a>
                            <div class="review-card-body">
                                <div class="reviewer-info">
                                    <div class="reviewer-initial {{ $avatarColors[$loop->index % count($avatarColors)] }}">{{ strtoupper(substr($rating->name ?? '', 0, 1)) }}</div>
                                    <div class="reviewer-details">
                                        <h4>{{ $rating->name }}</h4>
                                    </div>
                                </div>
                                <div class="review-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="review-text" title="{{ $rating->review }}">{{ $rating->review }}</p>
                            </div>
                            <div class="review-card-footer">
                                <div class="google-verified">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $rating->city }}
                                </div>
                                <a href="{{ $googleReviewUrl }}" target="_blank" rel="noopener noreferrer" class="review-google-link" aria-label="View on Google">
                                    <img src="https://www.gstatic.com/images/branding/product/1x/googleg_32dp.png" alt="Google" class="google-g-icon">
                                    <span>View on Google</span>
                                </a>
                            </div>
                        </div>
                        @endforeach

                        {{-- <!-- Review 2 -->
                <div class="review-card">
                    <div class="corner-glow top-left"></div>
                    <div class="corner-glow bottom-right"></div>
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="reviewer-info">
                        <div class="reviewer-initial color-red">F</div>
                        <div class="reviewer-details">
                            <h4>Fatima Ali</h4>
                            <!-- <span class="review-date">1 month ago</span> -->
                        </div>
                    </div>
                    <div class="review-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">Excellent customer support and very user-friendly interface. The team helped us migrate all our data smoothly. Our invoicing process is now 10x faster than before!</p>
                    <!-- <div class="google-verified">
                        <i class="fas fa-check-circle"></i>
                        Verified Purchase
                    </div> -->
                </div>

                <!-- Review 3 -->
                <div class="review-card">
                    <div class="corner-glow top-left"></div>
                    <div class="corner-glow bottom-right"></div>
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="reviewer-info">
                        <div class="reviewer-initial color-green">U</div>
                        <div class="reviewer-details">
                            <h4>Usman Malik</h4>
                            <!-- <span class="review-date">3 weeks ago</span> -->
                        </div>
                    </div>
                    <div class="review-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">As a tax consultant, I recommend BANG ERP to all my clients. The real-time FBR sync and comprehensive reporting features make tax compliance effortless.</p>
                    <!-- <div class="google-verified">
                        <i class="fas fa-check-circle"></i>
                        Verified Purchase
                    </div> -->
                </div>

                <!-- Review 4 -->
                <div class="review-card">
                    <div class="corner-glow top-left"></div>
                    <div class="corner-glow bottom-right"></div>
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="reviewer-info">
                        <div class="reviewer-initial color-yellow">H</div>
                        <div class="reviewer-details">
                            <h4>Hassan Raza</h4>
                            <!-- <span class="review-date">1 week ago</span> -->
                        </div>
                    </div>
                    <div class="review-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">Best investment for our retail business! The POS integration with FBR is flawless. We've reduced our accounting time by 70%. Thank you BANG team!</p>
                    <!-- <div class="google-verified">
                        <i class="fas fa-check-circle"></i>
                        Verified Purchase
                    </div> -->
                </div>

                <!-- Review 5 -->
                <div class="review-card">
                    <div class="corner-glow top-left"></div>
                    <div class="corner-glow bottom-right"></div>
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="reviewer-info">
                        <div class="reviewer-initial color-purple">A</div>
                        <div class="reviewer-details">
                            <h4>Ayesha Siddiqui</h4>
                            <!-- <span class="review-date">2 months ago</span> -->
                        </div>
                    </div>
                    <div class="review-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="review-text">Professional service and reliable software. The mobile app is a great addition - I can manage invoices on the go. Would definitely recommend to fellow entrepreneurs!</p>
                    <!-- <div class="google-verified">
                        <i class="fas fa-check-circle"></i>
                        Verified Purchase
                    </div> -->
                </div>

                <!-- Review 6 -->
                <div class="review-card">
                    <div class="corner-glow top-left"></div>
                    <div class="corner-glow bottom-right"></div>
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="reviewer-info">
                        <div class="reviewer-initial color-orange">B</div>
                        <div class="reviewer-details">
                            <h4>Bilal Ahmed</h4>
                            <!-- <span class="review-date">5 days ago</span> -->
                        </div>
                    </div>
                    <div class="review-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">Outstanding platform! The automated tax calculations save us hours every month. Their 24/7 support team is incredibly responsive and helpful. Five stars!</p>
                    <!-- <div class="google-verified">
                        <i class="fas fa-check-circle"></i>
                        Verified Purchase
                    </div> -->
                </div> --}}
                    </div>

                </div>
                <div class="reviews-controls">
                    <button class="reviews-btn" type="button" data-prev aria-label="Previous reviews">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="reviews-dots" data-dots></div>
                    <button class="reviews-btn" type="button" data-next aria-label="Next reviews">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

        </div>
    </section>

    <!-- Partners Section -->
    
    <section id="partners" class="partners-section">
        <div class="container">
            <div class="section-title">
                <span class="section-eyebrow">Partners</span>
                <h2>Our Trusted Compliance Partners</h2>
                <p>Collaborating with industry leaders and covering FBR, PRA, KPRA, SRB and BRA to deliver excellence in digital invoicing</p>
            </div>
            @if(count($clients) > 0)
            <p class="partners-trust-label"><i class="fas fa-shield-alt"></i> Trusted by leading businesses across Pakistan</p>
            <div class="partners-showcase">
                @foreach($clients as $client)
                <div class="partner-showcase-card" title="{{ $client->name }}">
                    @if($client->logo)
                        <img src="{{ asset('upload/clients/' . $client->logo) }}" alt="{{ $client->name }}">
                    @else
                        <img src="https://via.placeholder.com/200x100?text={{ urlencode($client->name) }}" alt="{{ $client->name }}">
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Partner Statistics -->
            <div class="partner-stats">
                <div class="partner-stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-handshake"></i></div>
                        <div class="stat-info">
                            <div class="stat-number" data-target="100" data-suffix="+">0</div>
                            <div class="stat-label">Active Partners</div>
                            <div class="stat-desc">Trusted integrations across industries</div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" data-percent="92"></div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-map-marked-alt"></i></div>
                        <div class="stat-info">
                            <div class="stat-number" data-target="50" data-suffix="+">0</div>
                            <div class="stat-label">Cities Covered</div>
                            <div class="stat-desc">Regional presence for fast onboarding</div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" data-percent="78"></div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="stat-info">
                            <div class="stat-number" data-target="98" data-suffix="%">0</div>
                            <div class="stat-label">Success Rate</div>
                            <div class="stat-desc">Deployment & compliance success across clients</div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" data-percent="98"></div>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-headset"></i></div>
                        <div class="stat-info">
                            <div class="stat-number" data-target="24" data-suffix="/7">0</div>
                            <div class="stat-label">Partner Support</div>
                            <div class="stat-desc">Dedicated assistance for partners</div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" data-percent="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-text">
                        <span class="section-eyebrow about-eyebrow">About Us</span>
                        <h2>About BANG.PK (Digital Solutions)</h2>
                        <p>BANG is a leading provider of digital invoicing solutions across Pakistan — supporting FBR, FBR POS, PRA (Punjab), KPRA (Khyber Pakhtunkhwa), SRB (Sindh) and BRA (Balochistan). We help businesses transition seamlessly to the digital economy with our ERP systems.</p>
                        <p>Our mission is to simplify tax compliance for businesses of all sizes through innovative technology. With years of experience in digital transformation, we understand the unique challenges faced by Pakistani businesses under federal and provincial tax authorities.</p>

                        <h4 style="font-weight: 700; margin-top: 24px; color: #0f172a;">Why BANG?</h4>
                        <ul class="about-why-list">
                            <li><i class="fas fa-check-circle"></i> FBR, PRA, KPRA, SRB &amp; BRA digital invoicing with real-time API sync</li>
                            <li><i class="fas fa-check-circle"></i> Trusted by 700+ businesses across 50+ cities in Pakistan</li>
                            <li><i class="fas fa-check-circle"></i> Complete ERP solution — invoicing, POS, inventory &amp; reports</li>
                            <li><i class="fas fa-check-circle"></i> Dedicated 24/7 support with onboarding &amp; training</li>
                            <li><i class="fas fa-check-circle"></i> Secure, cloud-based platform with 99.9% uptime</li>
                        </ul>

                        <div class="about-stats">
                            <div class="stat-item">
                                <span class="stat-number" data-target="700" data-suffix="+">0</span>
                                <span class="stat-label">Clients</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-target="50" data-suffix="+">0</span>
                                <span class="stat-label">Cities</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-target="24" data-suffix="/7">0</span>
                                <span class="stat-label">Support</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-target="99" data-suffix="%">0</span>
                                <span class="stat-label">Satisfaction</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <div class="about-images-grid">
                            <div class="about-img-main">
                                <img src="https://media.istockphoto.com/id/2182110555/photo/financial-report-and-banking-management-with-e-invoice-bill-digital-nline-statements-c2c.jpg?s=612x612&w=0&k=20&c=QmEXFY-ackuW4RtlABZxHsR6LCcPcxv8Nql-reTY1w8=" alt="Digital Invoicing">
                                <div class="img-overlay">
                                    <span><i class="fas fa-file-invoice-dollar"></i> Digital Invoicing</span>
                                </div>
                            </div>
                            <div class="about-img-side">
                                <div class="about-img-top">
                                    <img src="https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?auto=format&fit=crop&w=400&h=280&q=80" alt="Invoice Reports">
                                    <div class="img-overlay">
                                        <span><i class="fas fa-chart-line"></i> Invoice Reports</span>
                                    </div>
                                </div>
                                <div class="about-img-bottom">
                                    <img src="{{ asset('login-form-assets/img/img-4.png') }}" alt="Digital workspace">
                                    <div class="img-overlay">
                                        <span><i class="fas fa-laptop-code"></i> Smart Workspace</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Become Our Partner Section -->
    <section id="become-partner" class="become-partner-section">
        <div class="container">
            <div class="section-title">
                <h2>Become Our Partner</h2>
                <p>Join our network and grow your business with BANG ERP Solutions</p>
                <span class="partner-trust-line"><i class="fas fa-shield-alt"></i> Trusted by 100+ partners across Pakistan</span>
            </div>

            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="partner-form-container">
                        @if(session('success'))
                        <div class="alert alert-success" style="padding: 1rem; margin-bottom: 1.5rem; background: #d4edda; color: #155724; border-radius: 4px;">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger" style="padding: 1rem; margin-bottom: 1.5rem; background: #f8d7da; color: #721c24; border-radius: 4px;">
                            <ul style="margin: 0; padding-left: 1.5rem;">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <!-- <form id="partnerForm"> -->
                        <form action="{{ url('public_partner') }}" method="POST" id="testForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="fullName">Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="email">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" placeholder="Enter your address"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn">
                                <i class="fas fa-paper-plane me-2"></i>Submit Partnership Request
                            </button>
                        </form>
                    </div>

                    <div class="partner-benefits">
                        <h3>Why Partner With Us?</h3>
                        <div class="benefits-grid">
                            <div class="benefit-item">
                                <i class="fas fa-chart-line"></i>
                                <h4>Revenue Growth</h4>
                                <p>Increase your revenue streams with our proven FBR compliance solutions</p>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-graduation-cap"></i>
                                <h4>Training & Support</h4>
                                <p>Comprehensive training and 24/7 technical support for you and your clients</p>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-tools"></i>
                                <h4>Marketing Tools</h4>
                                <p>Access to marketing materials, demos, and sales collateral</p>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-handshake"></i>
                                <h4>Dedicated Support</h4>
                                <p>Personal account manager and priority support for all your clients</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="faq-section">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-eyebrow">FAQ</span>
                <h2>Frequently Asked Questions</h2>
                <p>Quick answers to common questions about BANG ERP and digital invoicing across Pakistan.</p>
            </div>
            <div class="faq-list">
                <div class="faq-item">
                    <button type="button" class="faq-question">
                        Which tax authorities does BANG support?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">BANG ERP supports FBR Digital Invoicing, FBR POS, PRA (Punjab Revenue Authority), KPRA (Khyber Pakhtunkhwa Revenue Authority), SRB (Sindh Revenue Board) and BRA (Balochistan Revenue Authority) — so you can stay compliant wherever you operate in Pakistan.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-question">
                        How long does setup take?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">Most businesses are up and running within 24–48 hours. Our team handles authority credential configuration, data migration, and staff training to ensure a smooth onboarding experience.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-question">
                        Is BANG ERP suitable for small businesses?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">Absolutely. BANG ERP scales from single-location retailers to multi-branch enterprises. Our flexible plans and intuitive interface make tax compliance accessible for businesses of all sizes.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-question">
                        Do you offer POS integration?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">Yes. BANG ERP includes built-in POS functionality with real-time invoice generation for FBR POS and provincial authorities — ideal for retail, restaurants, and wholesale businesses.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-question">
                        What support do you provide?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">We offer 24/7 technical support via phone, WhatsApp, and email. Every client gets onboarding assistance, training sessions, and a dedicated support team for ongoing help.</div>
                    </div>
                </div>
            </div>
            <div class="faq-cta">
                <a href="{{ url('/faq') }}" class="faq-cta-btn"><i class="fas fa-question-circle"></i> View All FAQs</a>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="final-cta-section">
        <div class="container">
            <div class="final-cta-inner">
                <h2>Ready for Nationwide Tax Compliance?</h2>
                <p>Join 700+ businesses already using BANG ERP for FBR, PRA, KPRA, SRB and BRA digital invoicing across Pakistan.</p>
                <div class="final-cta-buttons">
                    <a href="{{ asset('login') }}" class="hero-btn-primary"><i class="fas fa-rocket"></i> Login Now</a>
                    <a href="#become-partner" class="hero-btn-outline"><i class="fas fa-handshake"></i> Become a Partner</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="team-section d-none">
        <div class="container">
            <div class="section-title">
                <h2>Meet Our Leadership Team</h2>
                <p>The experts behind our innovative FBR compliance solutions</p>
            </div>

            <div class="row">
                <!-- Team Member 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop" alt="CEO">
                        </div>
                        <div class="member-info">
                            <h4>Ahmed Khan</h4>
                            <span class="position">CEO & Founder</span>
                            <p>With over 15 years of experience in digital solutions and tax compliance systems.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=300&fit=crop" alt="CTO">
                        </div>
                        <div class="member-info">
                            <h4>Sara Ahmed</h4>
                            <span class="position">Chief Technology Officer</span>
                            <p>Expert in ERP systems and FBR compliance with 12+ years of technical leadership.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=300&fit=crop" alt="Head of Sales">
                        </div>
                        <div class="member-info">
                            <h4>Usman Malik</h4>
                            <span class="position">Head of Sales</span>
                            <p>Driving business growth across Pakistan with 10+ years in enterprise solutions.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=300&fit=crop" alt="Head of Support">
                        </div>
                        <div class="member-info">
                            <h4>Fatima Raza</h4>
                            <span class="position">Head of Customer Support</span>
                            <p>Ensuring exceptional customer experience with dedicated 24/7 support teams.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('website.include.footer')

    <script src="{{ asset('js/website-home.js') }}"></script>

    <script>
        function updateActiveNavLink() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link:not(.nav-cta-btn)');

            let currentSection = '';

            sections.forEach(section => {
                const topBannerHeight = document.querySelector('.top-contact-banner').offsetHeight;
                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                const offset = topBannerHeight + navbarHeight + 100;

                const sectionTop = section.offsetTop - offset;
                const sectionHeight = section.clientHeight;

                if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                    currentSection = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${currentSection}`) {
                    link.classList.add('active');
                }
            });
        }

        // Animate on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    entry.target.style.animation = 'fadeInUp 0.8s ease forwards';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe elements for animation
        document.querySelectorAll('.video-item, .partner-showcase-card, .team-member, .about-image, .review-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Google Reviews Slider
        (function initReviewsSlider() {
            const slider = document.querySelector('[data-slider]');
            if (!slider) return;

            const track = slider.querySelector('.reviews-track');
            const cards = Array.from(slider.querySelectorAll('.review-card'));
            const prevBtn = slider.querySelector('[data-prev]');
            const nextBtn = slider.querySelector('[data-next]');
            const dotsWrap = slider.querySelector('[data-dots]');

            let index = 0;
            let autoTimer = null;

            const getPerView = () => {
                if (window.innerWidth <= 768) return 1;
                if (window.innerWidth <= 992) return 2;
                return 3;
            };

            const buildDots = () => {
                if (!dotsWrap) return;
                dotsWrap.innerHTML = '';
                const pages = Math.ceil(cards.length / getPerView());
                for (let i = 0; i < pages; i += 1) {
                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'reviews-dot' + (i === 0 ? ' active' : '');
                    dot.setAttribute('aria-label', `Go to reviews ${i + 1}`);
                    dot.addEventListener('click', () => goTo(i));
                    dotsWrap.appendChild(dot);
                }
            };

            const updateActiveCards = () => {
                const perView = getPerView();
                cards.forEach((card, i) => {
                    card.classList.toggle('is-center', i >= index * perView && i < (index + 1) * perView);
                });
            };

            const updateDots = () => {
                if (!dotsWrap) return;
                const dots = dotsWrap.querySelectorAll('.reviews-dot');
                dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
            };

            const goTo = (i) => {
                const perView = getPerView();
                const pages = Math.ceil(cards.length / perView);
                index = (i + pages) % pages;
                const cardWidth = track.querySelector('.review-card')?.offsetWidth || 0;
                const gap = parseFloat(getComputedStyle(track).gap || '0');
                const shift = (cardWidth + gap) * (index * perView);
                track.style.transform = `translateX(-${shift}px)`;
                updateDots();
                updateActiveCards();
            };

            const next = () => goTo(index + 1);
            const prev = () => goTo(index - 1);

            const startAuto = () => {
                stopAuto();
                autoTimer = setInterval(next, 4500);
            };

            const stopAuto = () => {
                if (autoTimer) clearInterval(autoTimer);
            };

            prevBtn?.addEventListener('click', () => {
                prev();
                startAuto();
            });

            nextBtn?.addEventListener('click', () => {
                next();
                startAuto();
            });

            slider.addEventListener('mouseenter', stopAuto);
            slider.addEventListener('mouseleave', startAuto);

            window.addEventListener('resize', () => {
                buildDots();
                goTo(index);
            });

            buildDots();
            goTo(0);
            startAuto();
        })();

        // Video loading state
        document.querySelectorAll('iframe').forEach(iframe => {
            iframe.addEventListener('load', function() {
                const loadingElement = this.parentElement.querySelector('.video-loading');
                if (loadingElement) {
                    loadingElement.style.display = 'none';
                }
            });
        });

        // Partner Form Submission
        document.getElementById('partnerForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = {
                fullName: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                city: document.getElementById('city').value,
                address: document.getElementById('address').value,
            };

            // Simple validation
            if (!formData.fullName || !formData.email || !formData.phone) {
                alert('Please fill all required fields (*)');
                return;
            }

            // Show success message (In production, this would send to a server)
            alert('Thank you for your partnership request! Our team will contact you within 24 hours.');

            // Reset form
            this.reset();

            // Scroll to top of form
            const formSection = document.getElementById('become-partner');
            const topBannerHeight = document.querySelector('.top-contact-banner').offsetHeight;
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            const offset = topBannerHeight + navbarHeight + 20;

            const targetPosition = formSection.getBoundingClientRect().top + window.pageYOffset - offset;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        });

        // Form field focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Get Started button functionality
        document.querySelector('.hero-btn')?.addEventListener('click', function() {
            const contactSection = document.getElementById('contact');
            const topBannerHeight = document.querySelector('.top-contact-banner').offsetHeight;
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            const offset = topBannerHeight + navbarHeight + 20;

            const targetPosition = contactSection.getBoundingClientRect().top + window.pageYOffset - offset;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        });

        // Add scroll event listener for active nav links
        window.addEventListener('scroll', function() {
            updateActiveNavLink();
        });

        // Initialize animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add active class to home link initially
            const homeLink = document.querySelector('.nav-link[href="#home"]');
            if (homeLink) {
                homeLink.classList.add('active');
            }
        });

        // Partner stats animation (counters + progress bars)
        (function() {
            function animatePartnerCounters() {
                document.querySelectorAll('.stat-number').forEach(el => {
                    const target = parseInt(el.getAttribute('data-target')) || 0;
                    const suffix = el.getAttribute('data-suffix') || '';
                    const isPercent = el.textContent.trim().endsWith('%') || el.getAttribute('data-target') && el.textContent.trim().includes('%');
                    let start = 0;
                    const duration = 1200;
                    const frameRate = 60;
                    const totalFrames = Math.round(duration / (1000 / frameRate));
                    const increment = target / totalFrames;

                    const run = () => {
                        start += increment;
                        if (start < target) {
                            el.textContent = Math.floor(start) + (isPercent ? '%' : '');
                            requestAnimationFrame(run);
                        } else {
                            el.textContent = target + (isPercent ? '%' : '') + suffix;
                        }
                    };
                    run();
                });

                // Fill progress bars
                document.querySelectorAll('.stat-progress-bar').forEach(bar => {
                    const p = bar.getAttribute('data-percent') || '80';
                    setTimeout(() => {
                        bar.style.width = p + '%';
                    }, 100);
                });
            }

            const statsSection = document.querySelector('.partner-stats');
            if (statsSection) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animatePartnerCounters();
                            obs.disconnect();
                        }
                    });
                }, {
                    threshold: 0.2
                });

                observer.observe(statsSection);
            }
        })();
    </script>
</body>

</html>