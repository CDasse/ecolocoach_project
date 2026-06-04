import {expect, test} from '@playwright/test';

test.use({storageState: {cookies: [], origins: []}});

test('Échec de connexion avec un mauvais mot de passe', async ({page}) => {
    await page.goto('/');
    await page.getByRole('link', {name: 'Me connecter'}).click();

    await page.getByRole('textbox', {name: 'Email'}).fill('elia@gmail.fr');
    await page.getByRole('textbox', {name: 'Mot de passe'}).fill('elia2');
    await page.getByRole('button', {name: 'Se connecter'}).click();

    await expect(page.getByText('Identifiants incorrects.')).toBeVisible();
});

test('Inscription d\'un nouvel utilisateur', async ({page}) => {
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
