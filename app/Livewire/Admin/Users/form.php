<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Form extends Component
{
    use AuthorizesRequests;

    public ?int $userId = null;

    public string $name = '';
    public string $email = '';
    public string $role = 'user';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(?int $userId = null): void
    {
        $this->userId = $userId;

        if ($userId) {
            $user = User::findOrFail($userId);
            $this->authorize('update', $user);
            $this->name  = $user->name;
            $this->email = $user->email;
            $this->role  = $user->role ?? 'user';
        } else {
            $this->authorize('create', User::class);
        }
    }

    protected function rules(): array
    {
        return [
            'name'  => ['required','string','min:3'],
            'email' => ['required','email', Rule::unique('users','email')->ignore($this->userId)],
            'role'  => ['required', Rule::in(['admin','vendedor','user'])],
            'password' => [$this->userId ? 'nullable' : 'required','confirmed','min:6'],
        ];
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $this->authorize('update', $user);

            $user->name  = $data['name'];
            $user->email = $data['email'];
            $user->role  = $data['role'];
            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            $user->save();

            session()->flash('success','Usuario actualizado.');
        } else {
            $this->authorize('create', User::class);

            User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'role'     => $data['role'],
                'password' => Hash::make($data['password']),
            ]);

            session()->flash('success','Usuario creado.');
            $this->reset(['name','email','role','password','password_confirmation']);
        }

        $this->dispatch('user-saved'); // si luego quieres escuchar en el padre
    }

    public function render()
    {
        return view('livewire.admin.users.form');
    }
}
