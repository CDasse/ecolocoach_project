import {expect, test} from '@playwright/test';

test.use({storageState: {cookies: [], origins: []}});

/**
 * Verifies that the login form correctly rejects invalid credentials
 * and displays an explicit error message.
 */
test('Should fail login with an incorrect password', async ({page}) => {
    await page.goto('/');
    await page.getByRole('link', {name: 'Me connecter'}).click();

    await page.getByRole('textbox', {name: 'Email'}).fill('elia@gmail.fr');
    await page.getByRole('textbox', {name: 'Mot de passe'}).fill('elia2');
    await page.getByRole('button', {name: 'Se connecter'}).click();

    await expect(page.getByText('Identifiants incorrects.')).toBeVisible();
});

/**
 * Validates the registration flow for a brand new user.
 * Uses a timestamp to guarantee a unique username and email on every run,
 * preventing database constraint conflicts.
 */
test('Should successfully register a new user', async ({page}) => {
    const uniqueId = Date.now();
    const uniqueEmail = `user_${uniqueId}@gmail.com`;
    const uniqueUsername = `User_${uniqueId}`;

    await page.goto('/');
    await page.getByRole('link', {name: 'Démarrer l\'aventure'}).click();

    await page.getByRole('textbox', {name: 'Nom d\'utilisateur'}).fill(uniqueUsername);
    await page.getByRole('textbox', {name: 'Email'}).fill(uniqueEmail);
    await page.getByRole('textbox', {name: 'Mot de passe'}).fill('MonSuperMotDePasse!');
    await page.getByRole('checkbox', {name: 'J\'accepte les conditions géné'}).check();
    await page.getByRole('button', {name: 'S\'inscrire'}).click();

    await expect(page.getByText('Ton compte est créé !')).toBeVisible();
});
