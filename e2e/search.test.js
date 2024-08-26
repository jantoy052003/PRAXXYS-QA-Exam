import { test, expect } from '@playwright/test';

test('Validate if user can search via Search Product field successfully', async ({page}) => {
    await page.goto('http://127.0.0.1:8000/login');
    await page.getByPlaceholder('Email').click();
    await page.getByPlaceholder('Email').fill('mayert.scot@example.com');
    await page.getByPlaceholder('Password').click();
    await page.getByPlaceholder('Password').fill('password');
    await page.getByRole('button', { name: 'Sign In' }).click();
    await page.getByPlaceholder('Search Product...').click();
    await page.getByPlaceholder('Search Product...').fill('quidem');
    await page.locator('.text-right > .btn').click();
    const table = page.locator('tbody');
    const cell = table.locator('tr td:nth-of-type(2)');
    await expect(cell).toContainText("Home & Furnitures")
    //await expect(page.locator('.text-center')).toHaveText("Home & Furnitures"); this displays all texts in the table
})

test('Validate is user can search via Select Category dropdown field successfully', async ({page}) => {
    await page.goto('http://127.0.0.1:8000/login');
    await page.getByPlaceholder('Email').click();
    await page.getByPlaceholder('Email').fill('mayert.scot@example.com');
    await page.getByPlaceholder('Password').click();
    await page.getByPlaceholder('Password').fill('password');
    await page.getByRole('button', { name: 'Sign In' }).click();
    await page.getByPlaceholder('Search Product...').click();
    await page.getByPlaceholder('Search Product...').fill('');
    await page.getByRole('combobox').selectOption('3');
    //await page.locator('#app a').first().click();
    await page.locator('.text-right > .btn').click();
    // const table = page.locator('.text-center');
    // const cell = table.locator('tr td:nth-of-type(2)');
    const result = page.locator('tbody');
    await expect(result).toHaveCount(1);
    const resultText = await result.first().innerText();
    await expect(resultText).toContain("Home & Furnitures");
})