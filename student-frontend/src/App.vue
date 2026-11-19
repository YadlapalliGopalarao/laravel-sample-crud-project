
<script setup>
import { ref, onMounted } from 'vue'

import api from './services/api'
import StudentForm from './components/StudentForm.vue'
import StudentTable from './components/StudentTable.vue'

const students = ref([])

const form = ref({
    name: '',
    email: '',
    city: ''
})

const message = ref('')
const messageType = ref('success')

const editingId = ref(null)
const saving = ref(false)

// Fetch students
async function getStudents() {
    try {
        const response = await api.get('/students')
        students.value = response.data.data
    } catch (error) {
        console.log(error)
        showMessage('Unable to fetch students.', 'error')
    }
}

// Display messages
function showMessage(text, type = 'success') {
    message.value = text
    messageType.value = type
}

// Reset form
function resetForm() {
    editingId.value = null

    form.value = {
        name: '',
        email: '',
        city: ''
    }
}

// Create student
async function createStudent() {
    saving.value = true

    try {
        const response = await api.post(
            '/students/create',
            form.value
        )

        showMessage(response.data.message)
        resetForm()
        await getStudents()

    } catch (error) {
        console.log(error.response?.data)

        showMessage(
            error.response?.data?.message || 'Unable to create student.',
            'error'
        )
    } finally {
        saving.value = false
    }
}

// Load student for editing
function editStudent(student) {
    editingId.value = student.id

    form.value = {
        name: student.name,
        email: student.email,
        city: student.city
    }

    message.value = ''
}

// Update student
async function updateStudent() {
    saving.value = true

    try {
        const response = await api.put(
            `/students/${editingId.value}`,
            form.value
        )

        showMessage(response.data.message)
        resetForm()
        await getStudents()

    } catch (error) {
        console.log(error.response?.data)

        showMessage(
            error.response?.data?.message || 'Unable to update student.',
            'error'
        )
    } finally {
        saving.value = false
    }
}

// Submit form
async function submitForm() {
    if (editingId.value !== null) {
        await updateStudent()
    } else {
        await createStudent()
    }
}

// Delete student
async function deleteStudent(id) {
    const confirmed = confirm(
        'Are you sure you want to delete this student?'
    )

    if (!confirmed) return

    try {
        const response = await api.delete(`/students/${id}`)

        showMessage(response.data.message)
        await getStudents()

    } catch (error) {
        console.log(error.response?.data)

        showMessage(
            error.response?.data?.message || 'Unable to delete student.',
            'error'
        )
    }
}

onMounted(() => {
    getStudents()
})
</script>

<template>
    <div class="app-wrapper">

        <header class="top-header">
            <div class="header-content">
                <div class="brand">
                    <div class="brand-icon">S</div>
                    <div>
                        <h2>StudentHub</h2>
                        <p>Management System</p>
                    </div>
                </div>

                <span class="system-status">
                    ● System Online
                </span>
            </div>
        </header>

        <main class="dashboard">

            <section class="welcome-section">
                <span class="eyebrow">DASHBOARD</span>
                <h1>Student Management</h1>
                <p>Manage student information in one place.</p>
            </section>

            <div
                v-if="message"
                class="alert-message"
                :class="messageType"
            >
                {{ message }}
                <button @click="message = ''">×</button>
            </div>

            <div class="content-grid">

                <StudentForm
                    :form="form"
                    :editing-id="editingId"
                    :saving="saving"
                    @submit="submitForm"
                    @reset="resetForm"
                />

                <StudentTable
                    :students="students"
                    @edit="editStudent"
                    @delete="deleteStudent"
                />

            </div>

        </main>

        <footer>
            StudentHub © 2026 | Student Management System
        </footer>

    </div>
</template>
