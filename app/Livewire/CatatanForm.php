<?php

namespace App\Livewire;

use App\Models\Catatan;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;

class CatatanForm extends Component implements HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use WithFileUploads;
    
    public $title;
    public $content;
    public $date;
    public $time;
    public $image_path;

    protected static ?string $model = Catatan::class; // Menghubungkan form dengan model Catatan

    public ?Catatan $record = null; // Properti untuk menyimpan instance model

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Judul')
                ->required(),
            Textarea::make('content')
                ->label('Cerita Kegiatanmu')
                ->required(),
            DatePicker::make('date')
                ->label('Tanggal')
                ->required(),
            TimePicker::make('time')
                ->label('Waktu')
                ->required(),
            FileUpload::make('image_path')
                ->label('Foto Kegiatan')
                ->image()
                ->directory('catatan-images')
                ->visibility('public')
                ->preserveFilenames()
                ->maxSize(2048)
                ->required()
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                ->columnSpanFull(),
        ]);
    }

    public function mount(?Catatan $catatan = null): void
    {
        $this->record = $catatan ?? new Catatan(); // Jika tidak ada record, buat instance baru
        $this->form->fill($this->record->toArray()); // Isi form dengan data dari model
    }

    public function submit()
    {
        // $data = $this->form->getState();

        // try {
        //     $this->record->fill($data); // Isi model dengan data dari form
        //     $this->record->save(); // Simpan model ke database

        //     session()->flash('success', 'Diary berhasil ditambahkan!');
        //     return redirect()->route('catatan.index');
        // } catch (\Exception $e) {
        //     logger()->error('Error saat menyimpan data:', ['error' => $e->getMessage()]);
        //     session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
        // }
        $path = null;

        if ($this->image_path instanceof \Livewire\TemporaryUploadedFile) {
            $path = $this->image_path->store('catatan-images', 'public');
        }

        Catatan::create([
            'title' => $this->title,
            'content' => $this->content,
            'image_path' => $path,
        ]);

        session()->flash('success', 'Data berhasil disimpan');
        return redirect()->route('catatan.index');
        }

    public function render(): View
    {
        return view('livewire.catatan-form', [
            'form' => static::form($this->form),
        ]);
    }
}
