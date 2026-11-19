<script setup>
defineProps({
    form: {
        type: Object,
        required: true
    },
    editingId: {
        type: [Number, null],
        default: null
    },
    saving: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['submit', 'reset'])
</script>

<template>
    <div class="form-card">
        <div class="section-heading">
            <div>
                <span class="eyebrow">STUDENT DETAILS</span>
                <h2>{{ editingId ? 'Update Student' : 'Add New Student' }}</h2>
                <p>Enter the student's information below.</p>
            </div>
            <div class="form-icon">✎</div>
        </div>

        <form @submit.prevent="emit('submit')">

            <div class="form-group">
                <label>Full Name</label>
                <input
                    v-model="form.name"
                    type="text"
                    placeholder="Enter student name"
                    required
                />
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input
                    v-model="form.email"
                    type="email"
                    placeholder="Enter email address"
                    required
                />
            </div>

            <div class="form-group">
                <label>City</label>
                <input
                    v-model="form.city"
                    type="text"
                    placeholder="Enter city"
                    required
                />
            </div>

            <div class="form-actions">
                <button
                    type="submit"
                    class="btn-primary"
                    :disabled="saving"
                >
                    {{ saving ? 'Please wait...' : editingId ? 'Update Student' : 'Create Student' }}
                </button>

                <button
                    v-if="editingId !== null"
                    type="button"
                    class="btn-secondary"
                    @click="emit('reset')"
                >
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>
