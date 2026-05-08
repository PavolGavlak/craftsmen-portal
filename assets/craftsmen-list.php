<?php $isAdminCraftsmenList = $isAdminCraftsmenList ?? false; ?>

<section class="main-heading">
    <h1><?= $isAdminCraftsmenList ? "Zoznam registrovaných členov" : "Remeselníci" ?></h1>
</section>

<section class="filter">
    <span class="filter-icon">&#128269;</span>
    <input type="text" class="filter-input" placeholder="Hľadať podľa mena">
    <select class="filter-select" aria-label="Filtrovať podľa remesla">
        <option value="">Všetky remeslá</option>
        <option value="kovac">Kováč</option>
        <option value="rezbar">Rezbár</option>
        <option value="krajcir">Krajčír</option>
        <option value="stolar">Stolár</option>
        <option value="drotar">Drotár</option>
        <option value="vcelar">Včelár</option>
        <option value="murar">Murár</option>
        <option value="tkac">Tkáč</option>
    </select>
</section>

<section class="craftsmen-list">
    <?php if (empty($craftsmen)): ?>
        <p class="empty-message">
            <?= $isAdminCraftsmenList ? "Členovia neboli nájdení." : "Zatiaľ nebol schválený žiaden remeselník." ?>
        </p>
    <?php else: ?>
        <div class="all-craftsmen">
            <?php foreach ($craftsmen as $one_craftsman): ?>
                <div class="one-craftsman" data-craft-name="<?= htmlspecialchars($one_craftsman["craft_name"]) ?>">
                    <?php
                    $fullName = htmlspecialchars($one_craftsman["first_name"]) . " " . htmlspecialchars($one_craftsman["second_name"]);
                    $displayBusinessName = ($one_craftsman["business_name"] ?? "") !== ""
                        ? $one_craftsman["business_name"]
                        : $one_craftsman["craft_name"];
                    $profileImage = !empty($one_craftsman["profile_photo_name"])
                        ? $imageBasePath . $one_craftsman["id"] . "/" . $one_craftsman["profile_photo_name"]
                        : null;
                    ?>
                    <a class="craftsman-profile-link" href="<?= sprintf($profileLinkPattern, $one_craftsman["id"]) ?>">
                        <div class="craftsman-heading">
                            <?php if ($profileImage): ?>
                                <img
                                    class="craftsman-profile-photo"
                                    src="<?= htmlspecialchars($profileImage) ?>"
                                    alt="<?= $fullName ?>"
                                >
                            <?php else: ?>
                                <div class="craftsman-profile-photo placeholder">
                                    <span><?= htmlspecialchars(strtoupper(substr($one_craftsman["first_name"], 0, 1))) ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="craftsman-title-block">
                                <h2><?= $fullName ?></h2>
                                <p class="craftsman-craft-name"><?= htmlspecialchars($displayBusinessName) ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
</section>
