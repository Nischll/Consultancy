# Tailwind CSS Build Instructions

## Issue
The node_modules were installed for a different platform (Windows). You need to reinstall dependencies for macOS.

## Solution

Run these commands in your terminal:

```bash
cd /Users/hsharan/Downloads/mocktest

# Remove node_modules and package-lock.json
rm -rf node_modules package-lock.json

# Reinstall dependencies for your platform (macOS ARM64)
npm install

# Build Tailwind CSS
npm run build
```

## Alternative: If npm install fails

If you encounter permission issues, try:

```bash
# Remove only the problematic esbuild packages
rm -rf node_modules/@esbuild
rm -rf node_modules/esbuild

# Reinstall esbuild for macOS ARM64
npm install esbuild@latest --save-dev

# Then build
npm run build
```

## For Development

If you want to watch for changes during development:

```bash
npm run dev
```

This will start Vite in development mode and automatically rebuild when you make changes.

## Verify Build

After building, check that the file exists:
- `public/build/assets/app-*.css` should contain your Tailwind styles

