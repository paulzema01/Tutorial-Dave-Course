// Live feedback for the registration form: password strength and whether the
// two password fields match. The server still validates everything.
export default ({ minLength = 8 } = {}) => ({
    password: '',
    confirmation: '',

    get meetsMinLength() {
        return this.password.length >= minLength;
    },

    // 0 = empty, 1 = weak (or too short), 2 = fair, 3 = good, 4 = strong.
    get strength() {
        const p = this.password;

        if (p.length === 0) return 0;
        if (p.length < minLength) return 1;

        let score = 0;
        if (p.length >= 12) score++;
        if (/[a-z]/.test(p) && /[A-Z]/.test(p)) score++;
        if (/\d/.test(p)) score++;
        if (/[^A-Za-z0-9]/.test(p)) score++;

        return Math.max(1, score);
    },

    get strengthLabel() {
        if (this.password.length === 0) return '';
        if (! this.meetsMinLength) return 'Too short';

        return ['', 'Weak', 'Fair', 'Good', 'Strong'][this.strength];
    },

    get strengthColor() {
        return ['bg-gray-200', 'bg-red-500', 'bg-amber-500', 'bg-lime-500', 'bg-emerald-500'][this.strength];
    },

    get strengthTextColor() {
        return ['text-gray-500', 'text-red-600', 'text-amber-600', 'text-lime-700', 'text-emerald-700'][this.strength];
    },

    // 'idle' until the confirmation field has something in it.
    get matchState() {
        if (this.confirmation.length === 0) return 'idle';

        return this.password === this.confirmation ? 'match' : 'mismatch';
    },
});
