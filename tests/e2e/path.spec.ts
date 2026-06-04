import {expect, test} from '@playwright/test';

test.describe.configure({mode: 'serial'});

test('Réalisation d\'une leçon', async ({page}) => {
    await page.goto('/path');
    await page.getByRole('link', {name: 'leçon 1'}).click();
    await page.getByRole('button', {name: 'Le train électrique'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await page.getByRole('link', {name: 'Continuer'}).click();
    await page.getByRole('button', {name: 'Le scooter thermique'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await expect(page.getByRole('button', {name: 'Terminer'})).toBeEnabled();
});

test('Accès à l\'évènement suivant après avoir terminé l\'événement courant', async ({page}) => {
    await page.goto('/path');
    await expect(page.getByText('leçon 2')).toBeVisible();

    await page.getByRole('link', {name: 'leçon 1'}).click();
    await page.getByRole('button', {name: 'L\'avion'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await page.getByRole('link', {name: 'Continuer'}).click();

    await page.getByRole('button', {name: 'Le covoiturage'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await page.getByRole('button', {name: 'Terminer'}).click();

    await expect(page.getByRole('link', {name: 'leçon 2'})).toBeEnabled();
});

test('Vérification des retours suite aux réponses des utilisateurs aux leçons', async ({page}) => {
    await page.goto('/path');

    await page.getByRole('link', {name: 'leçon 1'}).click();
    await page.getByRole('button', {name: 'L\'avion'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await expect(page.getByText('Bonne réponse !')).toBeVisible();

    await page.getByRole('link', {name: 'Continuer'}).click();
    await page.getByRole('button', {name: 'Le covoiturage'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await expect(page.getByText('Mauvaise réponse.')).toBeVisible();
    await page.getByRole('button', {name: 'Terminer'}).click();
});

test('Acceptation d\'un défi', async ({page}) => {
    await page.goto('/path');

    await page.getByRole('link', {name: 'leçon 2'}).click();
    await page.getByRole('button', {name: 'Le poireau local'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await page.getByRole('link', {name: 'Continuer'}).click();
    await page.getByRole('button', {name: 'Uniquement pour le style'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await page.getByRole('button', {name: 'Terminer'}).click();

    await page.getByRole('link', {name: 'défi 1'}).click();
    await page.getByRole('button', {name: 'Accepter ce défi !'}).click();

    await expect(page.getByText('BRAVO !')).toBeVisible();

    await page.getByRole('button', {name: 'Fermer la modale'}).click();
    await page.getByRole('button', {name: 'Ouvrir le menu principal'}).click();
    await page.getByRole('link', {name: 'Mon Impact'}).click();

    await expect(page.getByRole('heading', {name: 'Une journée 100% végétarienne'})).toBeVisible();
});

test('Augmentation du taux de CO2 économisé après avoir validé un défi', async ({page}) => {
    await page.goto('/impact');

    await expect(page.getByText('0,0 kg')).toBeVisible();

    await page.getByRole('button', {name: 'Voir plus ➔'}).click();
    await page.getByRole('button', {name: 'Défi validé !'}).click();
    await page.getByRole('button', {name: 'Fermer la modale'}).click();

    await expect(page.getByText('4,50 kg')).toBeVisible();
});
