import {expect, type Page, test} from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';

async function assertAccessibilityFor(page: Page, url: string, tags: string[]) {
    await page.goto(url);

    await page.waitForLoadState('domcontentloaded');

    const accessibilityScanResults = await new AxeBuilder({page})
        .withTags(tags)
        .analyze();

    expect(accessibilityScanResults.violations).toEqual([]);
}

const rgaaTag = ['RGAAv4'];
const wcagTags = ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa'];

// ==========================================
// PUBLIC PAGES
// ==========================================
test.describe('Accessibility tests - Public pages', () => {

    test.use({storageState: {cookies: [], origins: []}});

    const publicPages = ['/', '/login', '/register'];

    for (const url of publicPages) {
        test(`RGAA check on public pages : ${url}`, async ({page}) => {
            await assertAccessibilityFor(page, url, rgaaTag);
        });
    }

    for (const url of publicPages) {
        test(`WCAG check on public pages : ${url}`, async ({page}) => {
            await assertAccessibilityFor(page, url, wcagTags);
        });
    }
});

// ==========================================
// IN-APP PAGES
// ==========================================
test.describe('Accessibility tests - In-app pages', () => {

    const privatePages = [
        '/path',
        '/level',
        '/impact',
        '/impact/recap-challenges',
        '/community',
        '/profil',
    ];

    for (const url of privatePages) {
        test(`RGAA check on private pages : ${url}`, async ({page}) => {
            await assertAccessibilityFor(page, url, rgaaTag);
        });
    }

    for (const url of privatePages) {
        test(`WCAG check on private pages : ${url}`, async ({page}) => {
            await assertAccessibilityFor(page, url, wcagTags);
        });
    }
});
