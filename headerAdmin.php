        <header class="masthead mb-auto">
			<div class="inner">
				<nav class="nav nav-masthead justify-content-center">
					<?php
						echo "<div class='user'>".$_SESSION['email']."</div>";
					?>
					<a class="nav-link" href="strGlowna.php">Strona główna</a>
          			<a class="nav-link" href="przyjecie.php">Przyjęcie</a>
					<a class="nav-link" href="wydanie.php">Wydanie</a>
					<a class="nav-link" href="tworzenie.php">Tworzenie</a>
					<a class="nav-link" href="logout.php">Wyloguj</a>
				</nav>
			</div>
		</header>