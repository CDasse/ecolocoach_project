import {expect, test} from '@playwright/test';

test('La modale de défi s\'ouvre et se ferme correctement', async ({page}) => {
    await page.goto('/');

    await page.getByRole('link', {name: 'Démarrer l\'aventure'}).click();
    await page.getByRole('textbox', {name: 'Nom d\'utilisateur'}).click();
    await page.getByRole('textbox', {name: 'Nom d\'utilisateur'}).fill('Test');
    await page.getByRole('link', {name: 'Se connecter'}).click();
    await page.getByRole('textbox', {name: 'Mot de passe'}).click();
    await page.getByRole('textbox', {name: 'Mot de passe'}).fill('emile');
    await expect(page.getByRole('button', {name: 'Se connecter'})).toBeVisible();
});
