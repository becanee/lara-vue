<script setup lang="ts">
import { ref } from "vue";
import { useDark, useToggle } from "@vueuse/core";
import { Link } from "@inertiajs/vue3";
import { TbMoon, TbSunHigh } from 'vue-icons-plus/tb';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

const showingNavigationDropdown = ref(false);
const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>

<template>
  <div class="min-h-screen text-gray-600 dark:text-gray-100 bg-slate-200 dark:bg-zinc-800">
    <!-- Navigation -->
    <nav class="border-b border-slate-400 text-gray-600 dark:text-gray-100 bg-slate-200 dark:bg-zinc-800">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
          <!-- Left Side Navigation -->
          <div class="flex">
            <!-- Logo -->
            <div class="flex shrink-0 items-center">
              <Link :href="route('dashboard')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-600 dark:text-gray-100" />
              </Link>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <NavLink 
                :href="route('dashboard')" 
                :active="route().current('dashboard')"
                class="text-gray-600 dark:text-gray-100"
              >
                Dashboard
              </NavLink>
              <NavLink 
                :href="route('manage.user')" 
                :active="route().current('manage.user')"
                class="text-gray-600 dark:text-gray-100"
              >
                User Management
              </NavLink>
            </div>
          </div>

          <!-- Right Side Navigation -->
          <div class="hidden sm:ms-6 sm:flex sm:items-center">
            <!-- Theme Toggle -->
            <button @click="toggleDark()">
              <TbMoon v-if="!isDark" class="text-md" />
              <TbSunHigh v-if="isDark" class="text-md" />
            </button>

            <!-- User Dropdown -->
            <div class="relative ms-3">
              <el-col :span="24">
                <el-dropdown trigger="click">
                  <span class="el-dropdown-link">
                    <div class="flex ml-1 mt-4">
                      <el-avatar shape="square" size="small" src="https://cube.elemecdn.com/9/c2/f0ee8a3c7c9638a54940382568c9dpng.png" />
                      <p class="mt-2 ml-2">{{ $page.props.auth.user.name }}</p>
                    </div>
                    <el-icon class="el-icon--right"><arrow-down /></el-icon>
                  </span>

                  <template #dropdown>
                    <el-dropdown-menu>
                      <el-dropdown-item>
                        <Link :href="route('profile.edit')">Profile</Link>
                      </el-dropdown-item>
                      <el-dropdown-item>
                        <Link :href="route('logout')" method="post" as="button">Log Out</Link>
                      </el-dropdown-item>
                    </el-dropdown-menu>
                  </template>
                </el-dropdown>
              </el-col>
            </div>
          </div>

          <!-- Mobile Menu Button -->
          <div class="-me-2 flex items-center sm:hidden">
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
            >
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path
                  :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Navigation Menu -->
      <div
        :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
        class="sm:hidden"
      >
        <div class="space-y-1 pb-3 pt-2">
          <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
            Dashboard
          </ResponsiveNavLink>
        </div>

        <div class="border-t border-gray-200 pb-1 pt-4">
          <div class="px-4">
            <div class="text-base font-medium text-gray-800">{{ $page.props.auth.user.name }}</div>
            <div class="text-sm font-medium text-gray-500">{{ $page.props.auth.user.email }}</div>
          </div>

          <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
            <ResponsiveNavLink :href="route('logout')" method="post" as="button">Log Out</ResponsiveNavLink>
          </div>
        </div>
      </div>
    </nav>

    <!-- Header -->
    <header
      v-if="$slots.header"
      class="shadow text-gray-600 dark:text-gray-100 bg-slate-200 dark:bg-zinc-800"
    >
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <slot name="header" />
      </div>
    </header>

    <!-- Main Content -->
    <main>
      <slot />
    </main>
  </div>
</template>