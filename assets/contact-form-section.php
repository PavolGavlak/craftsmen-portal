<?php

$contact_section_id = $contact_section_id ?? null;
$contact_section_class = $contact_section_class ?? "contact-section";
$contact_form_action = $contact_form_action ?? "contact.php";
$is_contact_page = $contact_section_class === "contact-page-section";
?>

<section<?= $contact_section_id ? ' id="' . htmlspecialchars($contact_section_id) . '"' : "" ?> class="<?= htmlspecialchars($contact_section_class) ?>">
    <div class="contact-band-shell">
        <div class="contact-band-panel">
            <?php if ($is_contact_page): ?>
                <h1 class="contact-band-title">Kde nás nájdete</h1>
            <?php else: ?>
                <h2 class="contact-band-title">Kde nás nájdete</h2>
            <?php endif; ?>

            <div class="contact-band-location-layout">
                <div class="contact-band-address">
                    <p>Cech remeselníkov Žilinského kraja</p>
                    <p>Hlavná 125</p>
                    <p>010 01 Žilina</p>
                    <p>Telefón: +421 905 123 456</p>
                    <p>E-mail: info@cechremeselnikov.sk</p>
                </div>

                <div class="contact-band-map">
                    <iframe
                        title="Mapa sídla cechu remeselníkov"
                        src="https://www.google.com/maps?q=Hlavna%20125%2C%20010%2001%20Zilina&z=15&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <h3 class="contact-band-title contact-band-secondary-title">Kontaktujte nás</h3>

            <?php if ($is_contact_page): ?>
                <p class="contact-band-lead contact-band-lead-secondary">
                    Napíšte nám, ak hľadáte remeselníka, chcete odporučiť podujatie alebo sa potrebujete niečo opýtať.
                </p>
            <?php else: ?>
                <p class="contact-band-lead contact-band-lead-secondary">
                    Máte otázku, záujem o spoluprácu alebo chcete odporučiť remeselníka? Napíšte nám a ozveme sa vám.
                </p>
            <?php endif; ?>

            <?php if (!empty($contact_errors)): ?>
                <section class="contact-band-errors">
                    <ul>
                        <?php foreach ($contact_errors as $contact_error): ?>
                            <li><?= htmlspecialchars($contact_error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($contact_success_message !== ""): ?>
                <p class="contact-band-success"><?= htmlspecialchars($contact_success_message) ?></p>
            <?php endif; ?>

            <form class="contact-band-form" action="<?= htmlspecialchars($contact_form_action) ?>" method="POST">
                <input type="hidden" name="contact_form" value="1">

                <input
                    class="contact-band-field"
                    type="text"
                    name="first_name"
                    placeholder="Krstné meno"
                    value="<?= htmlspecialchars($contact_first_name) ?>"
                    required
                >

                <input
                    class="contact-band-field"
                    type="text"
                    name="second_name"
                    placeholder="Priezvisko"
                    value="<?= htmlspecialchars($contact_second_name) ?>"
                    required
                >

                <input
                    class="contact-band-field"
                    type="email"
                    name="email"
                    placeholder="E-mail"
                    value="<?= htmlspecialchars($contact_email) ?>"
                    required
                >

                <textarea
                    class="contact-band-field contact-band-textarea"
                    name="message"
                    placeholder="Vaša správa"
                    required
                ><?= htmlspecialchars($contact_message) ?></textarea>

                <button class="contact-band-button" type="submit">Odoslať</button>
            </form>
        </div>
    </div>
</section>