<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the photo management page
     */
    public function index(Business $business)
    {
        $this->authorize('update', $business);

        $currentPhotos = $business->photos ?? [];
        $maxPhotos = $business->getMaxPhotos();
        $remainingSlots = $business->getRemainingPhotoSlots();

        return view('business.photos', compact('business', 'currentPhotos', 'maxPhotos', 'remainingSlots'));
    }

    /**
     * Upload new photos
     */
    public function upload(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $request->validate([
            'photos' => 'required|array|max:10',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max per image
        ]);

        $uploadedPhotos = $request->file('photos');
        $photosCount = count($uploadedPhotos);

        // Check if user can upload this many photos
        if (!$business->canUploadPhotos($photosCount)) {
            return redirect()->back()
                ->with('error', "You can only upload {$business->getRemainingPhotoSlots()} more photo(s) with your current plan. Upgrade to upload more.");
        }

        $currentPhotos = $business->photos ?? [];
        $newPhotos = [];

        foreach ($uploadedPhotos as $photo) {
            // Store photo in storage/app/public/business-photos/{business-id}/
            $path = $photo->store("business-photos/{$business->id}", 'public');
            $newPhotos[] = $path;
        }

        // Merge with existing photos
        $allPhotos = array_merge($currentPhotos, $newPhotos);

        $business->update([
            'photos' => $allPhotos,
        ]);

        return redirect()->route('business.photos.index', $business)
            ->with('success', "Successfully uploaded {$photosCount} photo(s)!");
    }

    /**
     * Delete a photo
     */
    public function destroy(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $request->validate([
            'photo_path' => 'required|string',
        ]);

        $photoPath = $request->input('photo_path');
        $currentPhotos = $business->photos ?? [];

        // Check if photo exists in business photos
        if (!in_array($photoPath, $currentPhotos)) {
            return redirect()->back()
                ->with('error', 'Photo not found.');
        }

        // Remove from array
        $updatedPhotos = array_values(array_filter($currentPhotos, function ($photo) use ($photoPath) {
            return $photo !== $photoPath;
        }));

        // Delete physical file
        if (Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
        }

        $business->update([
            'photos' => $updatedPhotos,
        ]);

        return redirect()->route('business.photos.index', $business)
            ->with('success', 'Photo deleted successfully!');
    }

    /**
     * Set photo as logo/primary
     */
    public function setAsLogo(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $request->validate([
            'photo_path' => 'required|string',
        ]);

        $photoPath = $request->input('photo_path');
        $currentPhotos = $business->photos ?? [];

        // Check if photo exists in business photos
        if (!in_array($photoPath, $currentPhotos)) {
            return redirect()->back()
                ->with('error', 'Photo not found.');
        }

        $business->update([
            'logo' => $photoPath,
        ]);

        return redirect()->route('business.photos.index', $business)
            ->with('success', 'Photo set as logo successfully!');
    }
}
