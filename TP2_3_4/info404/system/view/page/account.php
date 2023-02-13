<?php
	$user = recupere_utilisateur($_SESSION['user']['id']);
?>
<div class="container">
	<div class="section">
		<p>Retrouvez et modifiez toutes les informations qui vous concernent.</p>
		<h5>Information pour la communauté</h5>
		<form method="post">
			<div class="row">
				<div class="col s6">
					<p>Niveau SQL</p>
<?php
	$levels = recupere_niveaux();
	foreach($levels as $level) {
?>
					<p>
						<input id="level_<?php echo $level['id']; ?>" type="radio" class="with-gap" name="niveau" value="<?php echo $level['id']; ?>"<?php if ($user['niveau'] == $level['id']) { echo ' checked="checked"'; } ?>/>
						<label for="level_<?php echo $level['id']; ?>"><?php echo $level['nom']; ?></label>
					</p>
<?php
	}
?>
				</div>
				<div class="col s6">
					<p>Spécialité(s)</p>
<?php
	$skills = recupere_competences();
	foreach($skills as $skill) {
?>
					<p>
						<input id="skill_<?php echo $skill['id']; ?>" type="checkbox" class="filled-in" name="competence[]" value="<?php echo $skill['id']; ?>"<?php if (in_array($skill['id'], $user['competences'])) { echo ' checked="checked"'; } ?>/>
						<label for="skill_<?php echo $skill['id']; ?>"><?php echo $skill['nom']; ?></label>
					</p>
<?php
	}
?>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<textarea id="message" class="materialize-textarea" name="message"><?php echo $user['message']; ?></textarea>
					<label for="message">Message</label>
				</div>
			</div>
			<div class="row">
				<p class="center">
					<button class="modal-action modal-close btn waves-effect waves-light" type="submit" name="information_update">Modifier les informations</button>
				</p>
			</div>
		</form>
		<p>&nbsp;</p>
		<h5>Modification du mot de passe</h5>
		<form method="post">
			<div class="row">
				<div class="input-field col s12">
					<input id="old-password" type="password" class="validate" name="ancien_mot_de_passe">
					<label for="old-password">Ancien mot de passe</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input id="password" type="password" class="validate" name="mot_de_passe">
					<label for="password">Nouveau mot de passe</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input id="confirmation" type="password" class="validate" name="confirmation">
					<label for="confirmation">Confirmation du nouveau mot de passe</label>
				</div>
			</div>
			<div class="row">
				<p class="center">
					<button class="modal-action modal-close btn waves-effect waves-light" type="submit" name="password_update">
						Modifier le mot de passe
					</button>
				</p>
			</div>
		</form>
	</div>
</div>