import { v4wp } from '@kucrut/vite-for-wp';

export default {
	plugins: [
		v4wp({
			input: {
				app: 'resources/assets/js/pressbooks-plugin-scaffold.js'
			},
			outDir: 'dist',
		})
	],
}
