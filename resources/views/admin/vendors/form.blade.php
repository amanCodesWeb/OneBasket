@extends('layouts.admin')

@section('title', isset($vendor) ? 'Edit Vendor' : 'New Vendor')
@section('heading', isset($vendor) ? 'Edit Vendor' : 'New Vendor')

@section('content')
    <div class="max-w-3xl">
        <form method="POST" action="{{ isset($vendor) ? route('admin.vendors.update', $vendor) : route('admin.vendors.store') }}" class="space-y-6">
            @csrf
            @if(isset($vendor)) @method('PUT') @endif

            {{-- Business Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Business Name</label>
                <input type="text" name="business_name" value="{{ old('business_name', $vendor->business_name ?? '') }}" required
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none @error('business_name') border-red-500 @enderror">
                @error('business_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- User (only on create) --}}
            @if(!isset($vendor))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Owner User</label>
                <select name="user_id" required
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none @error('user_id') border-red-500 @enderror">
                    <option value="">Select a user...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            @endif

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none @error('description') border-red-500 @enderror">{{ old('description', $vendor->description ?? '') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Address --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                    <input type="text" name="address" value="{{ old('address', $vendor->address ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $vendor->phone ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                {{-- WhatsApp --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $vendor->whatsapp ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" required
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" {{ old('status', $vendor->status ?? 'pending') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Delivery Radius --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Delivery Radius (km)</label>
                    <input type="number" step="0.5" name="delivery_radius_km" value="{{ old('delivery_radius_km', $vendor->delivery_radius_km ?? 5) }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
                {{-- Commission Rate --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Commission Rate (%)</label>
                    <input type="number" step="0.5" name="commission_rate" value="{{ old('commission_rate', $vendor->commission_rate ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 outline-none">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                    {{ isset($vendor) ? 'Update Vendor' : 'Create Vendor' }}
                </button>
                <a href="{{ route('admin.vendors.index') }}" class="text-gray-500 dark:text-gray-400 hover:underline text-sm">Cancel</a>
            </div>
        </form>
    </div>
@endsection
