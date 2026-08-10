<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LedgerFinance</title>
	<link rel="icon" type="image/png" href="/images/ledgerfinance.png">
	<style>
		#app-splash {
			position: fixed;
			inset: 0;
			z-index: 9999;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			gap: 1.25rem;
			background: #f8fafc;
			transition: opacity 0.35s ease, visibility 0.35s ease;
		}

		#app-splash.is-hidden {
			opacity: 0;
			visibility: hidden;
			pointer-events: none;
		}

		#app-splash img {
			height: 7rem;
			width: auto;
			max-width: min(80vw, 28rem);
			object-fit: contain;
		}

		#app-splash .splash-bar {
			width: 2.5rem;
			height: 0.2rem;
			border-radius: 9999px;
			background: #e2e8f0;
			overflow: hidden;
		}

		#app-splash .splash-bar::after {
			content: '';
			display: block;
			width: 40%;
			height: 100%;
			border-radius: inherit;
			background: #18181b;
			animation: splash-pulse 1.1s ease-in-out infinite;
		}

		@keyframes splash-pulse {
			0% {
				transform: translateX(-100%);
			}

			100% {
				transform: translateX(250%);
			}
		}
	</style>
</head>

<body>
	<div id="app-splash" aria-hidden="true">
		<img src="/images/ledgerfinance.png" alt="LedgerFinance" width="224" height="56">
		<div class="splash-bar"></div>
	</div>
	<div id="app"></div>
	@vite('resources/js/app.ts')
</body>

</html>