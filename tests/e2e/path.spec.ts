import {expect, Page, test} from '@playwright/test';

/**
 * End-to-End User Journey Test
 * Validates a complete core user loop:
 * 1. Completing a full lesson (Lesson 1) with correct & incorrect answers.
 * 2. Unlocking and completing the sequential lesson (Lesson 2).
 * 3. Discovering, accepting, and validating a challenge.
 * 4. Verifying CO2 savings increments on the Impact Dashboard.
 */
test('End-to-end user workflow within the application', async ({page}) => {
    await page.goto('/path');
    await expect(page.getByText('leçon 2')).toBeVisible();

    await completeLesson1Part1(page);
    await expect(page.getByText('Bonne réponse !')).toBeVisible();

    await completeLesson1Part2(page);
    await expect(page.getByText('Mauvaise réponse.')).toBeVisible();

    await finishLesson1(page);
    await expect(page.getByRole('link', {name: 'leçon 2'})).toBeEnabled();

    await completeLesson2(page);
    await acceptChallenge1(page);
    await expect(page.getByText('BRAVO !')).toBeVisible();

    await viewChallengeOnImpactPage(page);
    await expect(page.getByRole('heading', {name: 'Une journée 100% végétarienne'})).toBeVisible();

    await expect(page.getByText('0,0 kg')).toBeVisible();
    await validateChallenge1(page);
    await expect(page.getByText('4,50 kg')).toBeVisible();

});


async function completeLesson1Part1(page: Page) {
    await page.getByRole('link', {name: 'leçon 1'}).click();
    await page.getByRole('button', {name: 'L\'avion'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
}

async function completeLesson1Part2(page: Page) {
    await page.getByRole('link', {name: 'Continuer'}).click();
    await page.getByRole('button', {name: 'Le covoiturage'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
}

async function finishLesson1(page: Page) {
    await page.getByRole('button', {name: 'Terminer'}).click();
}

async function completeLesson2(page: Page) {
    await page.getByRole('link', {name: 'leçon 2'}).click();
    await page.getByRole('button', {name: 'Le poireau local'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await page.getByRole('link', {name: 'Continuer'}).click();
    await page.getByRole('button', {name: 'Uniquement pour le style'}).click();
    await page.getByRole('button', {name: 'Valider'}).click();
    await page.getByRole('button', {name: 'Terminer'}).click();
}

async function acceptChallenge1(page: Page) {
    await page.getByRole('link', {name: 'défi 1'}).click();
    await page.getByRole('button', {name: 'Accepter ce défi !'}).click();
}

async function viewChallengeOnImpactPage(page: Page) {
    await page.getByRole('button', {name: 'Fermer la modale'}).click();
    await page.getByRole('button', {name: 'Ouvrir le menu principal'}).click();
    await page.getByRole('link', {name: 'Mon Impact'}).click();
}

async function validateChallenge1(page: Page) {
    await page.getByRole('button', {name: 'Voir plus ➔'}).click();
    await page.getByRole('button', {name: 'Défi validé !'}).click();
    await page.getByRole('button', {name: 'Fermer la modale'}).click();
}
