import axios from "axios";

const selectPackage = async (packageId: number) => {
    try {
        const res = await axios.post(`/dashboard/packages/edit`, {
            package: packageId,
        });
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
    }
}


(() => {
    for (let i = 1; i < 4; i++) {
        const x = document.getElementById(`pickPackageBtn${i}`);
        if (x) {
            x.addEventListener('click', (e) => {
                selectPackage(i);
            });
        }
    }
})()
