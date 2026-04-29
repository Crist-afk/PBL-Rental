const fs = require('fs');
const file = 'resources/views/admin/profile.blade.php';
let content = fs.readFileSync(file, 'utf8');

// Replace primary text
content = content.replace(/text-\[var\(--text-primary,#443025\)\]/g, 'text-stone-900 [.dark-mode_&]:text-white');

// Replace secondary text
content = content.replace(/text-\[var\(--text-secondary,#8B5A2B\)\]/g, 'text-stone-600 [.dark-mode_&]:text-stone-300');

// Replace input borders
// Using a regex that matches <input ...> and replaces border-[var(--border-color)]
content = content.replace(/<input\b([^>]*)border-\[var\(--border-color\)\]([^>]*)>/g, '<input$1border-stone-300 [.dark-mode_&]:border-stone-600$2>');

fs.writeFileSync(file, content);
console.log('Replacements completed.');
