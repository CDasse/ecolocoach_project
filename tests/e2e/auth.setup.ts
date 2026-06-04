import {expect, test as setup} from '@playwright/test';

const authFile = 'playwright/.auth/user.json';

/**
 * Global Authentication Setup
 * * This setup file is responsible for authenticating a user (e.g., Elia)
 * before running the main test suite. It logs into the application once
 * and saves the session state (cookies and local storage) into a temporary file.
 * * Subsequent tests will reuse this saved state to start already authenticated.
 */
setup('Connexion à EcoloCoach sur le compte d\'Elia', async ({page}) => {
    await page.goto('/');
    await page.getByRole('link', {name: 'Me connecter'}).click();
    await page.getByRole('textbox', {name: 'Email'}).fill('elia@gmail.fr');
    await page.getByRole('textbox', {name: 'Mot de passe'}).fill('elia');
    await page.getByRole('button', {name: 'Se connecter'}).click();

    await expect(page.getByRole('button', {name: 'Ouvrir le menu principal'})).toBeVisible();

    await page.context().storageState({path: authFile});
});
